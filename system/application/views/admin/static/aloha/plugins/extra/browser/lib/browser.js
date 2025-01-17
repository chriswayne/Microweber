/**
 * Aloha.Browser
 *
 * The browser is an interface to interact with a Repository Managers.
 *
 * Reference:
 *		www.aloha-editor.org/wiki/Repository
 * 3rd party tools:
 *		www.jstree.com/documentation/core
 *		www.trirand.com/blog/ (jqGrid)
 *		layout.jquery-dev.net/
 */
define([
	
	'aloha/jquery',
	'util/class',
	'css!browser/css/browsercombined.css',
	'jquery-plugin!browser/vendor/jquery.ui',
	'jquery-plugin!browser/vendor/ui-layout',
	'jquery-plugin!browser/vendor/grid.locale.en',
	'jquery-plugin!browser/vendor/jquery.jqGrid',
	'jquery-plugin!browser/vendor/jquery.jstree'
	
], function (jQuery, Class) {

'use strict';

var
	uid = +(new Date),
	nsClasses = {
		tree              : 'aloha-browser-tree',
		'tree-header'     : 'aloha-browser-tree-header',
		'grab-handle'     : 'aloha-browser-grab-handle',
		shadow            : 'aloha-browser-shadow',
		'rounded-top'     : 'aloha-browser-rounded-top',
		list              : 'aloha-browser-list',
		'list-altrow'     : 'aloha-browser-list-altrow',
		'list-resizable'  : 'aloha-browser-list-resizable',
		'list-pager'      : 'aloha-browser-list-pager',
		'list-pager-left' : 'aloha-browser-list-pager-left',
		'list-btns'       : 'aloha-browser-list-btns',
		'search-btn'      : 'aloha-browser-search-btn',
		'search-field'    : 'aloha-browser-search-field',
		'search-icon'     : 'aloha-browser-search-icon',
		'close-btn'       : 'aloha-browser-close-btn',
		btn               : 'aloha-browser-btn',
		btns              : 'aloha-browser-btns',
		grid              : 'aloha-browser-grid',
		clear             : 'aloha-browser-clear',
		inner             : 'aloha-browser-inner',
		'modal-overlay'   : 'aloha-browser-modal-overlay',
		'modal-window'    : 'aloha-browser-modal-window'
	};

// ------------------------------------------------------------------------
// Local (helper) functions
// ------------------------------------------------------------------------

/**
 * Simple templating
 *
 * @param {String} str - The string containing placeholder keys in curly
 *                       brackets
 * @param {Object} obj - Associative array of replacing placeholder keys
 *                       with corresponding values
 */
function supplant (str, obj) {
	 return str.replace(/\{([a-z0-9\-\_]+)\}/ig, function (str, p1, offset, s) {
		 var replacement = obj[p1] || str;
		 return (typeof replacement === 'function') ? replacement() : replacement;
	 });
};

/**
 * Wrapper to call the supplant method on a given string, taking the
 * nsClasses object as the associative array containing the replacement
 * pairs
 *
 * @param {String} str
 * @return {String}
 */
function renderTemplate (str) {
	return (typeof str === 'string') ? supplant(str, nsClasses) : str;
};

/** 
 * @param {jQuery} el
 */
function disableSelection (el) {
	el.each(function() {           
		jQuery(this)
			.attr('unselectable', 'on')
			.css({
			   '-moz-user-select':'none',
			   '-webkit-user-select':'none',
			   'user-select':'none'
			})
			.each(function() {
			   this.onselectstart = function() { return false; };
			});
	});
};

var Browser = Class.extend({
	_constructor: function() {
		this.init.apply(this, arguments);
	},

	init: function(opts) {
		// Extend defaults
		var options = jQuery.extend({
			// Set to true for development and debugging
			verbose : false,
			// The repository manager which this browser will interface with
			repositoryManager : null,
			repositoryFilter  : [],
			objectTypeFilter  : [],
			renditionFilter   : ['cmis:none'], // ['*']
			filter : ['url'],
			// DOMObject to which this instance of browser is bound to
			element : undefined,
			// root folder id
			rootFolderId : 'aloha',
			// root path to where Browser resources are located
			rootPath  : '',
			treeWidth : 300,
			listWidth : 'auto',
			pageSize  : 10,
			columns : {
				icon    : {title: '',        width: 30,  sortable: false, resizable: false},
				name    : {title: 'Name',    width: 250, sorttype: 'text'},
				url     : {title: 'URL',     width: 250, sorttype: 'text'},
				preview : {title: 'Preview', width: 200, sorttype: 'text'}
			},
			isFloating : false
		}, opts || {});
		
		// If no element, the we will an overlay element onto which we will bind
		// our browser
		if (!options.element || !options.element.length) {
			options.isFloating = true;
			options.element = this.createOverlay();
		}
		
		// Hash to store callbacks functions for each instance of browser
		this._callbacks = {};
		// Cache of repository objects
		this._objs = {};
		//
		this._searchQuery = null;
		this._orderBy = null;
		
		//---------------------------------------------------------------------
		// paging properties
		//---------------------------------------------------------------------
		this._pagingOffset = 0;
		// Total number of objects in a given folder. We don't use null because
		// isNaN(null) == false ! *sigh*
		this._pagingCount = undefined;
		this._pagingBtns = {
			first : null,
			end   : null,
			next  : null,
			prev  : null
		};
		
		// Register user defined implement methods and callbacks, and remove
		// them from the options object
		// TODO: Consider deprecating this altogether
		if (typeof options.implement === 'object') {
			jQuery.each(options.implement, function (k, v) {
				that[k] = v;
			});
			
			delete options.implement;
		}
		
		// TODO: Consider deprecating this too
		if (typeof options.callbacks === 'object') {
			jQuery.each(options.callbacks, function () {
				that.callback(this[0], this[1]);
			});
			
			delete options.callbacks;
		}
		
		// Insert the remaining options as properties of this object
		jQuery.extend(this, options);
		
		var that = this;
		var tree_width = this.treeWidth;
		var give = tree_width / 5;
		
		this.preloadImages();
		
		this.element.attr('data-aloha-browser', ++uid).html('');
		// set the total element width (if configured)
		if (this.totalWidth) {
			this.element.width(this.totalWidth);
		}

		this.grid = this.createGrid(this.element).resize();
		this.tree = this.createTree(this.grid.find('.ui-layout-west'));
		this.list = this.createList(this.grid.find('.ui-layout-center'));
		
		this.grid.layout({
			west__size    : tree_width - 1,
			west__minSize : tree_width - give,
			west__maxSize : tree_width + give,
			center__size  : 'auto',
			paneClass     : 'ui-layout-pane',
			resizerClass  : 'ui-layout-resizer',
			togglerClass  : 'ui-layout-toggler',
			onresize      : function (name, element) {
				if (name == 'center') {
					that.list.setGridWidth(element.width());
				}
			}
			// , applyDefaultStyles: true // debugging
		}).sizePane('west', tree_width); // *** Fix for a ui-layout bug in chrome ***
		
		disableSelection(this.grid);
		
		// Not working
		jQuery('body').bind('aloha-repository-error', function (error) {
			console && console.warn && console.warn(
				'Error occured on request to repository: ',
				error.repository.repositoryId +
				'\nMessage: "' + error.message + '"'
			);
		});
		
		this.close();
	},
	
	destroy: function () {
	
	},
	
	instanceOf: 'Aloha.Browser',
	
	// ui components
	grid: null,
	tree: null,
	list: null,
	
	preloadImages: function () {
		var that = this;
		
		jQuery.each([
			'arrow-000-medium.png',
			'arrow-180.png',
			'arrow-315-medium.png',
			'arrow-stop-180.png',
			'arrow-stop.png',
			'arrow.png',
			'control-stop-square-small.png',
			'folder-horizontal-open.png',
			'folder-open.png',
			'magnifier-left.png',
			'page.png',
			'picture.png',
			'sort-alphabet-descending.png',
			'sort-alphabet.png'
		], function () {
			(new Image()).src = that.rootPath + 'img/' + this;
		});
	},
	
	/**
	 * TODO: Is there a way we can guard against potential infinite loops?
	 *
	 * @param {Associative Array Object} fn - Name of any Browser method
	 */
	trigger: function (fn, returned) {
		var cb = this._callbacks;
		var func = cb[fn];
		
		if (typeof func === 'object') {
			for (var i = 0, l = func.length; i < l; ++i) {
				if (typeof func[i] === 'function') {
					func[i].call(this, returned);
				}
			}
		}
	},
	
	/**
	 * Handles the binding of callbacks to any method in the browser.
	 * Removes the necessity for functions to manually trigger callbacks
	 * events within themselves by wrapping them within an function that
	 * does it on their behalf when necessary.
	 * A user can simply do the following:
	 *		browser.callback('anyFunction', function () { alert('called back'); });
	 * This will work regardless of whether browser.anyFunction manually
	 * triggers any events.
	 *
	 * this.enableCallbacks actually does most of the heavy lifting.
	 *
	 * @param {String} fn - Name of any browser method
	 * @param {Function} cb - Callback function to invoke
	 */
	callback: function (fn, cb) {
		if (typeof this[fn] != 'function') {
			console && console.warn(
				'Unable to add a callback to "' + fn +
				'" because it is not a method in Aloha.Browser.'
			);
			
			return this;
		}
		
		if (typeof cb !== 'function') {
			console && console.warn(
				'Unable to add a callback to "' + fn + '" because '	+
				'the callback object that was given is of type "'	+
				(typeof cb) + '". '									+
				'The callback object needs to be of type "function".'
			);
			
			return this;
		}
		
		if (this._callbacks[fn] == undefined) {
			if (this.enableCallbacks(fn)) {
				this._callbacks[fn] = [cb];
			}
		} else {
			this._callbacks[fn].push(cb);
		}
		
		return this;
	},
	
	/**
	 * Work-horse for this.callback method
	 */
	enableCallbacks: function (fn) {
		var browser_inst = this;
		var func = this[fn];
		
		if (typeof func === 'function') {
			this[fn] = function () {
				var returned = func.apply(browser_inst, arguments);
				browser_inst.trigger.call(browser_inst, fn, returned);
				return returned;
			};
			
			return true;
		} else {
			console && console.warn(
				'Cannot enable callbacks for function "' + fn +
				'" because no such method was found in Aloha.Browser.'
			);
			
			return false;
		}
	},
	
	getRepoChildren: function (params, callback) {
		var that = this;
		
		if (this.repositoryManager) {
			this.repositoryManager.getChildren(params, function (items) {
				that.processRepoResponse(items, callback);
			});
		}
	},
	
	queryRepository: function (params, callback) {
		var that = this;
		
		if (this.repositoryManager) {
			this.repositoryManager.query(params, function (response) {
				that.processRepoResponse(
					(response.results > 0) ? response.items : [],
					callback
				);
			});
		}
	},
	
	processRepoResponse: function (items, callback) {
		var that = this;
		var data = [];
		
		jQuery.each(items, function () {
			data.push(that.harvestRepoObject(this));
		});
		
		if (typeof callback === 'function') {
			callback.call(this, data);
		}
	},
	
	/**
	 * Convert a repository object into an object that can be used with our
	 * tree component. Also add a reference to this object in our objs hash.
	 * According to the Repository specification, each object will at least
	 * have the following properties at least: id, name, url, and type. Any
	 * and all other attributes are optional.
	 */
	harvestRepoObject: function (obj) {
		++uid;
		
		var repo_obj = this._objs[uid] = jQuery.extend(obj, {
			uid    : uid,
			loaded : false
		});
		
		return this.processRepoObject(repo_obj);
	},
	
	/**
	 * Should return an object that is usable with your tree component
	 */
	processRepoObject: function (obj) {
		var icon = '', attr;
		
		switch (obj.baseType) {
		case 'folder':
			icon = 'folder';
			break;
		case 'document':
			icon = 'document';
			break;
		}

		// if the object has a type set, we set it as type to the node
		if (obj.type) {
			attr = {rel: obj.type};
		}

		return {
			data: {
				title : obj.name, 
				attr  : {'data-rep-oobj': obj.uid}, 
				icon  : icon
			},
			attr : attr,
			state: (obj.hasMoreItems || obj.baseType === 'folder') ? 'closed' : null,
			resource: obj
		};
	},
	
	fetchRepoRoot: function (callback) {
		if (this.repositoryManager) {
			this.getRepoChildren(
				{
					inFolderId       : this.rootFolderId,
					repositoryFilter : this.repositoryFilter
				},
				function (data) {
					if (typeof callback === 'function') {
						callback(data);
					}
				}
			);
		}
	},
	
	/**
	 * User should implement this according to their needs
	 * @param Object item - Repository resource for a row
	 */
	renderRowCols: function (item) {
		var row = {};
		
		jQuery.each(this.columns, function (colName, v) {
			switch (colName) {
				case 'icon':
					row.icon = '<div class="aloha-browser-icon aloha-browser-icon-' + item.type + '"></div>';
					break;
				default:
					row[colName] = item[colName] || '--';
			}
		});
		
		return row;
	},
	
	/**
	 * User should implement this according to their needs
	 *
	 * @param {Object} item - Repository resource for a row
	 */
	onSelect: function (item) {},
	
	/**
	 * Fetch an object's  children if we haven't already done so
	 */
	fetchChildren: function (obj, callback) {
		var that = this;
		
		if (obj.hasMoreItems == true || obj.baseType === 'folder') {
			if (obj.loaded == false) {
				this.getRepoChildren(
					{
						inFolderId   : obj.id,
						repositoryId : obj.repositoryId
					},
					function (data) {
						that._objs[obj.uid].loaded = true;
						
						if (typeof callback === 'function') {
							callback(data);
						}
					}
				);
			}
		}
	},
	
	getObjectFromCache: function (node) {
		var obj;
		
		if (typeof node === 'object') {
			var uid = node.find('a:first').attr('data-rep-oobj');
			obj = this._objs[uid];
		}
		
		return obj;
	},
	
	rowClicked: function (event) {
		var row = jQuery(event.target).parent('tr');
		var item = null;
		
		if (row.length > 0) {
			var uid = row.attr('id');
			item = this._objs[uid];
			this.onSelect(item);
		}
		
		return item;
	},
	
	createTree: function (container) {
		var that = this;
		var tree = jQuery(renderTemplate('<div class="{tree}">'));
		var header = jQuery(renderTemplate(
				'<div class="{tree-header} {grab-handle}">\
					Repository Browser\
				</div>'
			));
		
		container.append(header, tree);
		
		tree.height(this.grid.height() - header.outerHeight(true))
			.bind('before.jstree', function (event, data) {
				//console && console.log(data.func);
			})
			.bind('loaded.jstree', function (event, data) {
				jQuery('>ul>li', this).first().css('padding-top', 5);
				tree.jstree("open_node", "li[rel='repository']");
			})
			.bind('select_node.jstree', function (event, data) {
				// Suppresses a bug in jsTree
				if (data.args[0].context) {
					return;
				}
				
				var node = data.rslt.obj;
				var folder = that.getObjectFromCache(node);
				
				if (typeof folder === 'object') {
					that._pagingOffset = 0;
					that._searchQuery = null;
					that._currentFolder = folder;
					that.fetchItems(folder, that.processItems);
				}
			})
			.jstree({
				types: that.types,
				rootFolderId: this.rootFolderId,
				plugins: ['themes', 'json_data', 'ui', 'types'],
				core: {
					animation: 250
				},
				themes: {
					theme : 'browser',
					url   : that.rootPath + 'css/jstree.css',
					dots  : true,
					icons : true
				},
				json_data: {
					data: function (node, callback) {
						if (that.repositoryManager) {
							that.jstree_callback = callback;
							that.fetchSubnodes.call(that, node, callback);
						} else {
							callback();
						}
					},
					correct_state: true
				},
				ui: {select_limit: 1}
			});
		
		return tree;
	},
	
	createGrid: function (container) {
		var grid = jQuery(renderTemplate(
				'<div class="{grid} {shadow} {rounded-top}"> \
					<div class="ui-layout-west"></div>		 \
					<div class="ui-layout-center"></div>	 \
				</div>'
			));
		
		container.append(grid);
		
		return grid;
	},
	
	createList: function (container) {
		var that = this;
		var list = jQuery(renderTemplate(
				'<table id="jqgrid_needs_something_anything_here"\
					class="{list}"></table>'
			));
		var colNames = [''];
		// This is a hidden utility column to help us with auto sorting
		var colModel = [{
				name	 : 'id',
				sorttype : 'int',
				firstsortorder : 'asc',
				hidden	 : true
			}];
		
		jQuery.each(this.columns, function (k, v) {
			colNames.push((v.title && v.title) ? v.title : '&nbsp;');
			colModel.push({
				name	  : k,
				width	  : v.width,
				sortable  : v.sortable,
				sorttype  : v.sorttype,
				resizable : v.resizable,
				fixed	  : v.fixed
			});
		});
		
		container.append(list,
			jQuery(renderTemplate('<div id="{list-pager}">'))
		);
		
		list.jqGrid({
			datatype     : 'local',
			width        : container.width(),
			shrinkToFit  : true,
			colNames     : colNames,
			colModel     : colModel,
			caption      : '&nbsp;',
			altRows      : true,
			altclass     : 'aloha-browser-list-altrow',
			resizeclass  : 'aloha-browser-list-resizable',
			pager        : '#aloha-browser-list-pager', // http://www.trirand.com/jqgridwiki/doku.php?id=wiki:pager&s[]=pager
		//	rowNum       : this.pageSize,	  // # of records to view in the grid. Passed as parameter to url when retrieving data from server
			viewrecords  : true,
			// Event handlers: http://www.trirand.com/jqgridwiki/doku.php?id=wiki:events
			// fires after click on [page button] and before populating the data
			onPaging     : function (button) {},
			// Called if the request fails
			loadError    : function (xhr, status, error) {},
			// Raised immediately after row was double clicked. 
			ondblClickRow: function (rowid, iRow, iCol, e) {},
			// fires after all the data is loaded into the grid and all other processes are complete
			gridComplete : function () {},
			// executed immediately after every server request 
			loadComplete : function (data) {}
		});
		
		container.find('.ui-jqgrid-bdiv').height(
			this.grid.height() - (
				container.find('.ui-jqgrid-titlebar').height() +
				container.find('.ui-jqgrid-hdiv').height() + 
				container.find('.ui-jqgrid-pager').height()
			)
		);
		
		list.click(function () {
			that.rowClicked.apply(that, arguments);
		});
		
		// Override jqGrid paging
		container
			.find('.ui-pg-button').unbind()
			.find('>span.ui-icon').each(function () {
				var dir = this.className
							  .match(/ui\-icon\-seek\-([a-z]+)/)[1];
					
					that._pagingBtns[dir] =
						jQuery(this)
							.parent()
							.addClass('ui-state-disabled')
							.click(function () {
								if (!jQuery(this)
										.hasClass('ui-state-disabled')) {
											that.doPaging(dir);
										}
							});
				});
		
		// TODO: implement this once repositories can handle it, hidding it for now
		container.find('.ui-pg-input').parent().hide()
		container.find('.ui-separator').parent().css('opacity', 0).first().hide();
		container.find('#aloha-browser-list-pager-left').hide();
		
		this.createTitlebar(container);
		
		//this.grid.find('.loading').html('Loading...');
		
		// Override jqGrid sorting
		var listProps = list[0].p;
		container.find('.ui-jqgrid-view tr:first th div').each(function(i) {
			if (listProps.colModel[i].sortable !== false) {
				jQuery(this).unbind().click(function (event) {
					event.stopPropagation();
					that.sortList(listProps.colModel[i], this);
				});
			}
		});
		
		return list;
	},
	
	createTitlebar: function (container) {
		var that = this, searchField;
		var bar  = container.find('.ui-jqgrid-titlebar');
		var btns = jQuery(renderTemplate(
				'<div class="{btns}">							 \
					<input type="text" class="{search-field}" /> \
					<span class="{btn} {search-btn}">			 \
						<span class="{search-icon}"></span>		 \
					</span>										 \
					<span class="{btn} {close-btn}">Close</span> \
					<div class="{clear}"></div>					 \
				</div>'
			));
		
		bar.addClass('aloha-browser-grab-handle').append(btns);
		bar.find('.aloha-browser-search-btn').click(function () {
			that.triggerSearch();
		});
		searchField = bar.find('.aloha-browser-search-field').keypress(function (event) {
			if (event.keyCode == 13) { // on Enter
				that.triggerSearch();
			}
		});
		
		var prefilledValue = "Input search text...";
		searchField.val(prefilledValue).addClass("aloha-browser-search-field-empty")
		.focus(function() {
			if (jQuery(this).val() == prefilledValue) {
				jQuery(this)
					.val("")
					.removeClass("aloha-browser-search-field-empty");
			}
		}) .blur(function() {
			if (jQuery(this).val() == "") {
				jQuery(this)
					.val(prefilledValue)
					.addClass("aloha-browser-search-field-empty");
			}
		});

		bar.find('.aloha-browser-close-btn').click(function () {
			that.close();
		});
		bar.find('.aloha-browser-btn').mousedown(function () {
			jQuery(this).addClass('aloha-browser-pressed');
		}).mouseup(function () {
			jQuery(this).removeClass('aloha-browser-pressed');
		});
	},
	
	triggerSearch: function () {
		var search = this.grid.find('input.aloha-browser-search-field'), searchValue = search.val();

		if (jQuery(search).css("font-style") == "italic") {
			searchValue = "";
		}

		this._pagingOffset = 0;
		this._searchQuery  = search.val();
		
		this.fetchItems(this._currentFolder, this.processItems);
	},
	
	/**
	 * TODO: Fix this so that sorting does toggle between desc and asc
	 *		 when you click on a column on which we were not sorting.
	 */
	sortList: function(colModel, el){
		// reset sort properties in all column headers
		jQuery('span.ui-grid-ico-sort').addClass('ui-state-disabled');
		
		colModel.sortorder = (colModel.sortorder == 'asc') ? 'desc' : 'asc';
		
		jQuery(el).find('span.s-ico').show()
			 .find('.ui-icon-' + colModel.sortorder)
			 .removeClass('ui-state-disabled');
		
		this.setSortOrder(colModel.name, colModel.sortorder)
			.fetchItems(this._currentFolder, this.processItems);
	},
	
	/**
	 * This function adds new sort fields into the _orderBy array.
	 * If a field already exists, it will be spliced from where it is and
	 * unshifted to the end of the array
	 */
	setSortOrder: function (by, order) {
		var sortItem = {};
		sortItem[by] = order || 'asc';
		
		var orderBy = this._orderBy || [];
		var field;
		var orderItem;
		var found = false;
		
		for (var i = 0, j = orderBy.length; i < j; ++i) {
			orderItem = orderBy[i];
			
			for (field in orderItem) {
				if (field === by) {
					orderBy.splice(i, 1);
					orderBy.unshift(sortItem);
					found = true;
					break;
				}
			}
			
			if (found) {
				break;
			}
		}
		
		found || orderBy.unshift(sortItem);
		
		this._orderBy = orderBy;
		
		return this;
	},
	
	getFieldOfHeader: function (th) {
		return th.find('div.ui-jqgrid-sortable').attr('id').replace('jqgh_', '');
	},
	
	doPaging: function (dir) {
		switch (dir) {
			case 'first':
				this._pagingOffset = 0;
				break;
			case 'end':
				this._pagingOffset = this._pagingCount - this.pageSize;
				break;
			case 'next':
				this._pagingOffset += this.pageSize;
				break;
			case 'prev':
				this._pagingOffset -= this.pageSize;
				break;
		}
		
		// TODO: animate
		//var grid = this.grid.find('.ui-jqgrid-bdiv');
		//grid.animate({marginLeft: -grid.width()}, 500);
		
		this.fetchItems(this._currentFolder, this.processItems);
	},
	
	fetchItems: function (folder, callback) {
		if (!folder) {
			return;
		}
		
		this.list.setCaption(
			(typeof this._searchQuery === 'string')
				? 'Searching for "' + this._searchQuery + '" in ' + folder.name
				: 'Browsing: ' + folder.name
		);
		
		this.list.hide();
		this.grid.find('.loading').show();
		
		var that = this;
		
		this.queryRepository(
			{
				repositoryId     : folder.repositoryId,
				inFolderId       : folder.id,
				queryString      : this._searchQuery,
				orderBy          : this._orderBy,
				skipCount        : this._pagingOffset,
				maxItems         : this.pageSize,
				objectTypeFilter : this.objectTypeFilter,
				renditionFilter  : this.renditionFilter,
				filter           : this.filter,
				recursive		 : false
			},
			function (data) {
				if (typeof callback === 'function') {
					callback.call(that, data);
				}
			}
		);
	},
	
	fetchSubnodes: function (node, callback) {
		if (node === -1) {
			this.fetchRepoRoot(callback);
		} else {
			var obj = this.getObjectFromCache(node);
			if (typeof obj === 'object') {
				this.fetchChildren(obj, callback);
			}
		}
	},
	
	listItems: function (items) {
		var that = this;		
		var list = this.list.clearGridData();
		
		jQuery.each(items, function () {
			var obj = this.resource;
			list.addRowData(
				obj.uid,
				jQuery.extend({id: obj.id}, that.renderRowCols(obj))
			);
		});
	},
	
	processItems: function (data) {
		var btns = this._pagingBtns;
		var disabled = 'ui-state-disabled';
		
		this.grid.find('.loading').hide();
		this.list.show();
		this.listItems(data);
		
		if (this._pagingOffset <= 0) {
			btns.first.add(btns.prev).addClass(disabled);
		} else {
			btns.first.add(btns.prev).removeClass(disabled);
		}
		
		if (isNaN(this._pagingCount)) {
			btns.end.addClass(disabled);
			
			if (data.length < this.pageSize) {
				btns.next.addClass(disabled);
			} else {
				btns.next.removeClass(disabled);
			}
		} else if (this._pagingOffset + this.pageSize >= this._pagingCount) {
			btns.end.add(btns.next).addClass(disabled);
		} else {
			btns.end.add(btns.next).removeClass(disabled);
		}
		
		var from, to;
		
		if (data.length == 0 && this._pagingOffset == 0) {
			from = 0;
			to = 0;
		} else {
			from = this._pagingOffset + 1;
			to = from + data.length - 1;
		}
		
		this.grid.find('.ui-paging-info').html(
			'Viewing ' +		  (from)
					   + ' - '  + (to)
					   + ' of ' + (this._pagingCount || 'numerous')
		);
	},
	
	createOverlay: function () {
		var that = this;
		
		jQuery('body').append(renderTemplate(
			'<div class="{modal-overlay}" style="top: -99999px; z-index: 99999;"></div>' +
			'<div class="{modal-window}"  style="top: -99999px; z-index: 99999;"></div>'
		));
		
		jQuery('.aloha-browser-modal-overlay').click(function () {
			that.close();
		});
		
		return jQuery('.aloha-browser-modal-window');
	},
	
	setObjectTypeFilter: function (otf) {
		this.objectTypeFilter = typeof otf === 'string' ? [otf] : otf;
	},
	
	getObjectTypeFilter: function () {
		return this.objectTypeFilter;
	},
	
	show: function () {
		this.opened = true;
		
		// this.fetchRepoRoot(this.jstree_callback);
		
		var el = this.element;
		
		if (this.isFloating) {
			el.find('.aloha-browser-close-btn').show();
			
			jQuery('.aloha-browser-modal-overlay')
				.css({top: 0, left: 0})
				.add(el).stop().show();
			
			var win	= jQuery(window);
			
			el.css({
				left : (win.width()  - el.width())  / 2,
				top  : (win.height() - el.height()) / 3
			}).draggable({
				handle: el.find('.aloha-browser-grab-handle')
			}).resizable();
			
			// Do wake-up animation
			this.grid.css({
				marginTop : 30,
				opacity   : 0
			}).animate({
				marginTop : 0,
				opacity   : 1
			}, 1500, 'easeOutExpo', function () {
				// Disable filter to prevent IE<=8 filter bug
				if (jQuery.browser.msie) {
					jQuery(this).add(el).css(
						'filter',
						'progid:DXImageTransform.Microsoft.gradient(enabled = false)'
					);
				}
			});
		} else {
			el.stop().show().css({
				opacity: 1,
				filter: 'progid:DXImageTransform.Microsoft.gradient(enabled = false)'
			});
			el.find('.aloha-browser-close-btn').hide();
		}
	},
	
	close: function () {
		this.opened = true;
		
		this.element.fadeOut(
			250, function () {
				jQuery(this).css('top', 0).hide();
				jQuery('.aloha-browser-modal-overlay').hide();
			}
		);
	},

	/**
	 * Refresh the browser
	 */
	refresh: function () {
		// TODO: refresh the tree?

		// refresh the list, if we have a current folder
		if (this._currentFolder) {
			this.fetchItems(this._currentFolder, this.processItems);
		}
	}

});

return Browser;

});