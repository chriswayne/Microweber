/*
htmLawed_README.txt, 23 April 2009
htmLawed 1.1.8, 23 April 2009
Copyright Santosh Patnaik
GPL v3 license
A PHP Labware internal utility - http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed
*/


== Content ==========================================================


1  About htmLawed
  1.1  Example uses
  1.2  Features
  1.3  History
  1.4  License & copyright
  1.5  Terms used here
2  Usage
  2.1  Simple
  2.2  Configuring htmLawed using the '$config' parameter
  2.3  Extra HTML specifications using the '$spec' parameter
  2.4  Performance time & memory usage
  2.5  Some security risks to keep in mind
  2.6  Use without modifying old 'kses()' code
  2.7  Tolerance for ill-written HTML
  2.8  Limitations & work-arounds
  2.9  Examples
3  Details
  3.1  Invalid/dangerous characters
  3.2  Character references/entities
  3.3  HTML elements
    3.3.1  HTML comments and 'CDATA' sections
    3.3.2  Tag-transformation for better XHTML-Strict
    3.3.3  Tag balancing and proper nesting
    3.3.4  Elements requiring child elements
    3.3.5  Beautify or compact HTML
  3.4  Attributes
    3.4.1  Auto-addition of XHTML-required attributes
    3.4.2  Duplicate/invalid 'id' values
    3.4.3  URL schemes (protocols) and scripts in attribute values
    3.4.4  Absolute & relative URLs
    3.4.5  Lower-cased, standard attribute values
    3.4.6  Transformation of deprecated attributes
    3.4.7  Anti-spam & 'href'
    3.4.8  Inline style properties
    3.4.9  Hook function for tag content
  3.5  Simple configuration directive for most valid XHTML
  3.6  Simple configuration directive for most `safe` HTML
  3.7  Using a hook function
  3.8  Obtaining `finalized` parameter values
  3.9  Retaining non-HTML tags in input with mixed markup
4  Other
  4.1  Support
  4.2  Known issues
  4.3  Change-log
  4.4  Testing
  4.5  Upgrade, & old versions
  4.6  Comparison with 'HTMLPurifier'
  4.7  Use through application plug-ins/modules
  4.8  Use in non-PHP applications
  4.9  Donate
  4.10  Acknowledgements
5  Appendices
  5.1  Characters discouraged in HTML
  5.2  Valid attribute-element combinations
  5.3  CSS 2.1 properties accepting URLs
  5.4  Microsoft Windows 1252 character replacements
  5.5  URL format
  5.6  Brief on htmLawed code


== 1  About htmLawed ================================================


  htmLawed is a highly customizable single-file PHP script to make text secure, and standard- and admin policy-compliant for use in the body of HTML 4, XHTML 1 or 1.1, or generic XML documents. It is thus a configurable input (X)HTML filter, processor, purifier, sanitizer, beautifier, etc., and an alternative to the HTMLTidy:- http://tidy.sourceforge.net application.

  The `lawing in` of input text is needed to ensure that HTML code in the text is standard-compliant, does not introduce security vulnerabilities, and does not break the aesthetics, design or layout of web-pages. htmLawed tries to do this by, for example, making HTML well-formed with balanced and properly nested tags, neutralizing code that may be used for cross-site scripting ('XSS') attacks, and allowing only specified HTML elements/tags and attributes.


-- 1.1  Example uses ------------------------------------------------


  *  Filtering of text submitted as comments on blogs to allow only certain HTML elements

  *  Making RSS/Atom newsfeed item-content standard-compliant: often one uses an excerpt from an HTML document for the content, and with unbalanced tags, non-numerical entities, etc., such excerpts may not be XML-compliant

  *  Text processing for stricter XML standard-compliance: e.g., to have lowercased 'x' in hexadecimal numeric entities becomes necessary if an XHTML document with MathML content needs to be served as 'application/xml'

  *  Scraping text or data from web-pages

  *  Pretty-printing HTML code


-- 1.2  Features ---------------------------------------------------o


  Key: '*' security feature, '^' standard compliance, '~' requires setting right options, '`' different from 'Kses'

  *  make input more *secure* and *standard-compliant*
  *  use for HTML 4, XHTML 1.0 or 1.1, or even generic *XML* documents  ^~`

  *  *beautify* or *compact* HTML  ^~`

  *  *restrict elements*  ^~`
  *  proper closure of empty elements like 'img'  ^`
  *  *transform deprecated elements* like 'u'  ^~`
  *  HTML *comments* and 'CDATA' sections can be permitted  ^~`
  *  elements like 'script', 'object' and 'form' can be permitted  ~

  *  *restrict attributes*, including *element-specifically*  ^~`
  *  remove *invalid attributes*  ^`
  *  element and attribute names are *lower-cased*  ^
  *  provide *required attributes*, like 'alt' for 'image'  ^`
  *  *transform deprecated attributes*  ^~`
  *  attributes *declared only once*  ^`

  *  *restrict attribute values*, including *element-specifically*  ^~`
  *  a value is declared for `empty` (`minimized`) attributes like 'checked'  ^
  *  check for potentially dangerous attribute values  *~
  *  ensure *unique* 'id' attribute values  ^~`
  *  *double-quote* attribute values  ^
  *  lower-case *standard attribute values* like 'password'  ^`

  *  *attribute-specific URL protocol/scheme restriction*  *~`
  *  disable *dynamic expressions* in 'style' values  *~`

  *  neutralize invalid named character entities  ^`
  *  *convert* hexadecimal numeric entities to decimal ones, or vice versa  ^~`
  *  convert named entities to numeric ones for generic XML use  ^~`

  *  remove *null* characters  *
  *  neutralize potentially dangerous proprietary Netscape *Javascript entities*  *
  *  replace potentially dangerous *soft-hyphen* character in attribute values with spaces  *

  *  remove common *invalid characters* not allowed in HTML or XML  ^`
  *  replace *characters from Microsoft applications* like 'Word' that are discouraged in HTML or XML  ^~`
  *  neutralize entities for characters invalid or discouraged in HTML or XML  ^`
  *  appropriately neutralize '<', '&', '"', and '>' characters  ^*`

  *  understands improperly spaced tag content (like, spread over more than a line) and properly spaces them  `
  *  attempts to *balance tags* for well-formedness  ^~`
  *  understands when *omitable closing tags* like '</p>' (allowed in HTML 4, transitional, e.g.) are missing  ^~`
  *  attempts to permit only *validly nested tags*  ^~`
  *  option to *remove or neutralize bad content* ^~`
  *  attempts to *rectify common errors of plain-text misplacement* (e.g., directly inside 'blockquote') ^~`

  *  fast, *non-OOP* code of ~45 kb incurring peak basal memory usage of ~0.5 MB
  *  *compatible* with pre-existing code using 'Kses' (the filter used by 'WordPress')

  *  optional *anti-spam* measures such as addition of 'rel="nofollow"' and link-disabling  ~`
  *  optionally makes *relative URLs absolute*, and vice versa  ~`

  *  optionally mark '&' to identify the entities for '&', '<' and '>' introduced by htmLawed  ~`

  *  allows deployment of powerful *hook functions* to *inject* HTML, *consolidate* 'style' attributes to 'class', finely check attribute values, etc.  ~`

  *  *independent of character encoding* of input and does not affect it

  *  *tolerance for ill-written HTML* to a certain degree


-- 1.3  History ----------------------------------------------------o


  htmLawed was developed for use with 'LabWiki', a wiki software developed at PHP Labware, as a suitable software could not be found. Existing PHP software like 'Kses' and 'HTMLPurifier' were deemed inadequate, slow, resource-intensive, or dependent on external applications like 'HTML Tidy'.

  htmLawed started as a modification of Ulf Harnhammar's 'Kses' (version 0.2.2) software, and is compatible with code that uses 'Kses'; see section:- #2.6.


-- 1.4  License & copyright ----------------------------------------o


  htmLawed is free and open-source software licensed under GPL license version 3:- http://www.gnu.org/licenses/gpl-3.0.txt, and copyrighted by Santosh Patnaik, MD, PhD.


-- 1.5  Terms used here --------------------------------------------o


  *  `administrator` - or admin; person setting up the code to pass input through htmLawed; also, `user`
  *  `attributes` - name-value pairs like 'href="http://x.com"' in opening tags
  *  `author` - `writer`
  *  `character` - atomic unit of text; internally represented by a numeric `code-point` as specified by the `encoding` or `charset` in use
  *  `entity` - markup like '&gt;' and '&#160;' used to refer to a character
  *  `element` - HTML element like 'a' and 'img'
  *  `element content` -  content between the opening and closing tags of an element, like 'click' of '<a href="x">click</a>'
  *  `HTML` - implies XHTML unless specified otherwise
  *  `input` - text string given to htmLawed to process
  *  `processing` - involves filtering, correction, etc., of input
  *  `safe` - absence or reduction of certain characters and HTML elements and attributes in the input that can otherwise potentially and circumstantially expose web-site users to security vulnerabilities like cross-site scripting attacks (XSS)
  *  `scheme` - URL protocol like 'http' and 'ftp'
  *  `specs` - standard specifications
  *  `style property` - terms like 'border' and 'height' for which declarations are made in values for the 'style' attribute of elements
  *  `tag` - markers like '<a href="x">' and '</a>' delineating element content; the opening tag can contain attributes
  *  `tag content` - consists of tag markers '<' and '>', element names like 'div', and possibly attributes
  *  `user` - administrator
  *  `writer` - end-user like a blog commenter providing the input that is to be processed; also, `author`


== 2  Usage ========================================================oo


  htmLawed should work with PHP 4.3 and higher. Either 'include()' the 'htmLawed.php' file or copy-paste the entire code.

  To easily *test* htmLawed using a form-based interface, use the provided demo:- htmLawedTest.php ('htmLawed.php' and 'htmLawedTest.php' should be in the same directory on the web-server).


-- 2.1  Simple ------------------------------------------------------


  The input text to be processed, '$text', is passed as an argument of type string; 'htmLawed()' returns the processed string:

    $processed = htmLawed($text);

  *Note*: If input is from a '$_GET' or '$_POST' value, and 'magic quotes' are enabled on the PHP setup, run 'stripslashes()' on the input before passing to htmLawed.

  By default, htmLawed will process the text allowing all valid HTML elements/tags, secure URL scheme/CSS style properties, etc. It will allow 'CDATA' sections and HTML comments, balance tags, and ensure proper nesting of elements. Such actions can be configured using two other optional arguments -- '$config' and '$spec':

    $processed = htmLawed($text, $config, $spec);

  These extra parameters are detailed below. Some examples are shown in section:- #2.9.

  *Note*: For maximum protection against 'XSS' and other scripting attacks (e.g., by disallowing Javascript code), consider using the 'safe' parameter; see section:- #3.6.


-- 2.2  Configuring htmLawed using the '$config' parameter ---------o


  '$config' instructs htmLawed on how to tackle certain tasks. When '$config' is not specified, or not set as an array (e.g., '$config = 1'), htmLawed will take default actions. One or many of the task-action or value-specification pairs can be specified in '$config' as array key-value pairs. If a parameter is not specified, htmLawed will use the default value/action indicated further below.

    $config = array('comment'=>0, 'cdata'=>1);
    $processed = htmLawed($text, $config);

  Or,

    $processed = htmLawed($text, array('comment'=>0, 'cdata'=>1));

  Below are the possible value-specification combinations. In PHP code, values that are integers should not be quoted and should be used as numeric types (unless meant as string/text).

  Key: '*' default, '^' different default when htmLawed is used in the Kses-compatible mode (see section:- #2.6), '~' different default when 'valid_xhtml' is set to '1' (see section:- #3.5), '"' different default when 'safe' is set to '1' (see section:- #3.6)

  *abs_url*
  Make URLs absolute or relative; '$config["base_url"]' needs to be set; see section:- #3.4.4

  '-1' - make relative
  '0' - no action  *
  '1' - make absolute

  *and_mark*
  Mark '&' characters in the original input; see section:- #3.2

  *anti_link_spam*
  Anti-link-spam measure; see section:- #3.4.7
      
  '0' - no measure taken  *
  'array("regex1", "regex2")' - will ensure a 'rel' attribute with 'nofollow' in its value in case the 'href' attribute value matches the regular expression pattern 'regex1', and/or will remove 'href' if its value matches the regular expression pattern 'regex2'. E.g., 'array("/./", "/://\W*(?!(abc\.com|xyz\.org))/")'; see section:- #3.4.7 for more.

  *anti_mail_spam*
  Anti-mail-spam measure; see section:- #3.4.7

  '0' - no measure taken  *
  'word' - '@' in mail address in 'href' attribute value is replaced with specified 'word'

  *balance*
  Balance tags for well-formedness and proper nesting; see section:- #3.3.3

  '0' - no
  '1' - yes  *

  *base_url*
  Base URL value that needs to be set if '$config["abs_url"]' is not '0'; see section:- #3.4.4

  *cdata*
  Handling of 'CDATA' sections; see section:- #3.3.1

  '0' - don't consider 'CDATA' sections as markup and proceed as if plain text  ^"
  '1' - remove
  '2' - allow, but neutralize any '<', '>', and '&' inside by converting them to named entities
  '3' - allow  *

  *clean_ms_char*
  Replace discouraged characters introduced by Microsoft Word, etc.; see section:- #3.1

  '0' - no  *
  '1' - yes
  '2' - yes, but replace special single & double quotes with ordinary ones

  *comment*
  Handling of HTML comments; see section:- #3.3.1

  '0' - don't consider comments as markup and proceed as if plain text  ^"
  '1' - remove
  '2' - allow, but neutralize any '<', '>', and '&' inside by converting to named entities
  '3' - allow  *

  *css_expression*
  Allow dynamic CSS expression by not removing the expression from CSS property values in 'style' attributes; see section:- #3.4.8

  '0' - remove  *
  '1' - allow

  *deny_attribute*
  Denied HTML attributes; see section:- #3.4

  '0' - none  *
  'string' - dictated by values in 'string'
  'on*' (like 'onfocus') attributes not allowed - "

  *elements*
  Allowed HTML elements; see section:- #3.3

  '* -center -dir -font -isindex -menu -s -strike -u' -  ~
  'applet, embed, iframe, object, script' not allowed - "

  *hexdec_entity*
  Allow hexadecimal numeric entities and do not convert to the more widely accepted decimal ones, or convert decimal to hexadecimal ones; see section:- #3.2

  '0' - no
  '1' - yes  *
  '2' - convert decimal to hexadecimal ones

  *hook*
  Name of an optional hook function to alter the input string, '$config' or '$spec' before htmLawed starts its main work; see section:- #3.7

  '0' - no hook function  *
  'name' - 'name' is name of the hook function ('kses_hook'  ^)

  *hook_tag*
  Name of an optional hook function to alter tag content finalized by htmLawed; see section:- #3.4.9

  '0' - no hook function  *
  'name' - 'name' is name of the hook function

  *keep_bad*
  Neutralize bad tags by converting '<' and '>' to entities, or remove them; see section:- #3.3.3

  '0' - remove  ^
  '1' - neutralize both tags and element content
  '2' - remove tags but neutralize element content
  '3' and '4' - like '1' and '2' but remove if text ('pcdata') is invalid in parent element
  '5' and '6' * -  like '3' and '4' but line-breaks, tabs and spaces are left

  *lc_std_val*
  For XHTML compliance, predefined, standard attribute values, like 'get' for the 'method' attribute of 'form', must be lowercased; see section:- #3.4.5

  '0' - no
  '1' - yes  *

  *make_tag_strict*
  Transform/remove these non-strict XHTML elements, even if they are allowed by the admin: 'applet' 'center' 'dir' 'embed' 'font' 'isindex' 'menu' 's' 'strike' 'u'; see section:- #3.3.2

  '0' - no  ^
  '1' - yes, but leave 'applet', 'embed' and 'isindex' elements that currently can't be transformed  *
  '2' - yes, removing 'applet', 'embed' and 'isindex' elements and their contents (nested elements remain)  ~

  *named_entity*
  Allow non-universal named HTML entities, or convert to numeric ones; see section:- #3.2

  '0' - convert
  '1' - allow  *

  *no_deprecated_attr*
  Allow deprecated attributes or transform them; see section:- #3.4.6

  '0' - allow  ^
  '1' - transform, but 'name' attributes for 'a' and 'map' are retained  *
  '2' - transform

  *parent*
  Name of the parent element, possibly imagined, that will hold the input; see section:- #3.3

  *safe*
  Magic parameter to make input the most secure against XSS without needing to specify other relevant '$config' parameters; see section:- #3.6

  '0' - no  *
  '1' - will auto-adjust other relevant '$config' parameters (indicated by '"' in this list)

  *schemes*
  Array of attribute-specific, comma-separated, lower-cased list of schemes (protocols) allowed in attributes accepting URLs; '*' covers all unspecified attributes; see section:- #3.4.3

  'href: aim, feed, file, ftp, gopher, http, https, irc, mailto, news, nntp, sftp, ssh, telnet; *:file, http, https'  *
  '*: ftp, gopher, http, https, mailto, news, nntp, telnet'  ^
  'href: aim, feed, file, ftp, gopher, http, https, irc, mailto, news, nntp, sftp, ssh, telnet; style: nil; *:file, http, https'  "

  *show_setting*
  Name of a PHP variable to assign the `finalized` '$config' and '$spec' values; see section:- #3.8

  *style_pass*
  Do not look at 'style' attribute values, letting them through without any alteration

  '0' - no *
  '1' - htmLawed will let through any 'style' value; see section:- #3.4.8

  *tidy*
  Beautify or compact HTML code; see section:- #3.3.5

  '-1' - compact
  '0' - no  *
  '1' or 'string' - beautify (custom format specified by 'string')

  *unique_ids*
  'id' attribute value checks; see section:- #3.4.2

  '0' - no  ^
  '1' - remove duplicate and/or invalid ones  *
  'word' - remove invalid ones and replace duplicate ones with new and unique ones based on the 'word'; the admin-specified 'word', like 'my_', should begin with a letter (a-z) and can contain letters, digits, '.', '_', '-', and ':'.

  *valid_xhtml*
  Magic parameter to make input the most valid XHTML without needing to specify other relevant '$config' parameters; see section:- #3.5

  '0' - no  *
  '1' - will auto-adjust other relevant '$config' parameters (indicated by '~' in this list)

  *xml:lang*
  Auto-adding 'xml:lang' attribute; see section:- #3.4.1

  '0' - no  *
  '1' - add if 'lang' attribute is present
  '2' - add if 'lang' attribute is present, and remove 'lang'  ~


-- 2.3  Extra HTML specifications using the $spec parameter --------o


  The '$spec' argument can be used to disallow an otherwise legal attribute for an element, or to restrict the attribute's values. This can also be helpful as a security measure (e.g., in certain versions of browsers, certain values can cause buffer overflows and denial of service attacks), or in enforcing admin policy compliance. '$spec' is specified as a string of text containing one or more `rules`, with multiple rules separated from each other by a semi-colon (';'). E.g.,

    $spec = 'i=-*; td, tr=style, id, -*; a=id(match="/[a-z][a-z\d.:\-`"]*/i"/minval=2), href(maxlen=100/minlen=34); img=-width,-alt';
    $processed = htmLawed($text, $config, $spec);

  Or,

    $processed = htmLawed($text, $config, 'i=-*; td, tr=style, id, -*; a=id(match="/[a-z][a-z\d.:\-`"]*/i"/minval=2), href(maxlen=100/minlen=34); img=-width,-alt');

  A rule begins with an HTML *element* name(s) (`rule-element`), for which the rule applies, followed by an equal ('=') sign. A rule-element may represent multiple elements if comma (,)-separated element names are used. E.g., 'th,td,tr='.

  Rest of the rule consists of comma-separated HTML *attribute names*. A minus ('-') character before an attribute means that the attribute is not permitted inside the rule-element. E.g., '-width'. To deny all attributes, '-*' can be used.

  Following shows examples of rule excerpts with rule-element 'a' and the attributes that are being permitted:

  *  'a=' - all
  *  'a=id' - all
  *  'a=href, title, -id, -onclick' - all except 'id' and 'onclick'
  *  'a=*, id, -id' - all except 'id'
  *  'a=-*' - none
  *  'a=-*, href, title' - none except 'href' and 'title'
  *  'a=-*, -id, href, title' - none except 'href' and 'title'

  Rules regarding *attribute values* are optionally specified inside round brackets after attribute names in slash ('/')-separated `parameter = value` pairs. E.g., 'title(maxlen=30/minlen=5)'. None, or one or more of the following parameters may be specified:

  *  'oneof' - one or more choices separated by '|' that the value should match; if only one choice is provided, then the value must match that choice

  *  'noneof' - one or more choices separated by '|' that the value should not match

  *  'maxlen' and 'minlen' - upper and lower limits for the number of characters in the attribute value; specified in numbers

  *  'maxval' and 'minval' - upper and lower limits for the numerical value specified in the attribute value; specified in numbers

  *  'match' and 'nomatch' - pattern that the attribute value should or should not match; specified as PHP/PCRE-compatible regular expressions with delimiters and possibly modifiers

  *  'default' - a value to force on the attribute if the value provided by the writer does not fit any of the specified parameters

  If 'default' is not set and the attribute value does not satisfy any of the specified parameters, then the attribute is removed. The 'default' value can also be used to force all attribute declarations to take the same value (by getting the values declared illegal by setting, e.g., 'maxlen' to '-1').

  Examples with `input` '<input title="WIDTH" value="10em" /><input title="length" value="5" />' are shown below.

  `Rule`: 'input=title(maxlen=60/minlen=6), value'
  `Output`: '<input value="10em" /><input title="length" value="5" />'

  `Rule`: 'input=title(), value(maxval=8/default=6)'
  `Output`: '<input title="WIDTH" value="6" /><input title="length" value="5" />'

  `Rule`: 'input=title(nomatch=$w.d$i), value(match=$em$/default=6em)'
  `Output`: '<input value="10em" /><input title="length" value="6em" />'

  `Rule`: 'input=title(oneof=height|depth/default=depth), value(noneof=5|6)'
  `Output`: '<input title="depth" value="10em" /><input title="depth" />'

  *Special characters*: The characters ';', ',', '/', '(', ')', '|', '~' and space have special meanings in the rules. Words in the rules that use such characters, or the characters themselves, should be `escaped` by enclosing in pairs of double-quotes ('"'). A back-tick ('`') can be used to escape a literal '"'. An example rule illustrating this is 'input=value(maxlen=30/match="/^\w/"/default="your `"ID`"")'.
   
  *Note*: To deny an attribute for all elements for which it is legal, '$config["deny_attribute"]' (see section:- #3.4) can be used instead of '$spec'. Also, attributes can be allowed element-specifically through '$spec' while being denied globally through '$config["deny_attribute"]'. The 'hook_tag' parameter (section:- #3.4.9) can also be used to implement the '$spec' functionality.


-- 2.4  Performance time & memory usage ----------------------------o


  The time and memory used by htmLawed depends on its configuration and the size of the input, and the amount, nestedness and well-formedness of the HTML markup within it. In particular, tag balancing and beautification each can increase the processing time by about a quarter.

  The htmLawed demo:- htmLawedTest.php can be used to evaluate the performance and effects of different types of input and '$config'.


-- 2.5  Some security risks to keep in mind ------------------------o


  When setting the parameters/arguments (like those to allow certain HTML elements) for use with htmLawed, one should bear in mind that the setting may let through potentially `dangerous` HTML code. (This may not be a problem if the authors are trusted.)

  For example, following increase security risks:

  *  Allowing 'script', 'applet', 'embed', 'iframe' or 'object' elements, or certain of their attributes like 'allowscriptaccess'

  *  Allowing HTML comments (some Internet Explorer versions are vulnerable with, e.g., '<!--[if gte IE 4]><script>alert("xss");</script><![endif]-->'
  
  *  Allowing dynamic CSS expressions (a feature of the IE browser)

  `Unsafe` HTML can be removed by setting '$config' appropriately. E.g., '$config["elements"] = "* -script"' (section:- #3.3), '$config["safe"] = 1' (section:- #3.6), etc.


-- 2.6  Use without modifying old 'kses()' code --------------------o


  The 'Kses' PHP script is used by many applications (like 'WordPress'). It is possible to have such applications use htmLawed instead, since it is compatible with code that calls the 'kses()' function declared in the 'Kses' file (usually named 'kses.php'). E.g., application code like this will continue to work after replacing 'Kses' with htmLawed:

    $comment_filtered = kses($comment_input, array('a'=>array(), 'b'=>array(), 'i'=>array()));

  For some of the '$config' parameters, htmLawed will use values other than the default ones. These are indicated by '^' in section:- #2.2. To force htmLawed to use other values, function 'kses()' in the htmLawed code should be edited -- a few configurable parameters/variables need to be changed.

  If the application uses a 'Kses' file that has the 'kses()' function declared, then, to have the application use htmLawed instead of 'Kses', simply rename 'htmLawed.php' (to 'kses.php', e.g.) and replace the 'Kses' file (or just replace the code in the 'Kses' file with the htmLawed code). If the 'kses()' function in the 'Kses' file had been renamed by the application developer (e.g., in 'WordPress', it is named 'wp_kses()'), then appropriately rename the 'kses()' function in the htmLawed code.

  If the 'Kses' file used by the application has been highly altered by the application developers, then one may need a different approach. E.g., with 'WordPress', it is best to copy the htmLawed code to 'wp_includes/kses.php', rename the newly added function 'kses()' to 'wp_kses()', and delete the code for the original 'wp_kses()' function.

  If the 'Kses' code has a non-empty hook function (e.g., 'wp_kses_hook()' in case of 'WordPress'), then the code for htmLawed's 'kses_hook()' function should be appropriately edited. However, the requirement of the hook function should be re-evaluated considering that htmLawed has extra capabilities. With 'WordPress', the hook function is an essential one. The following code is suggested for the htmLawed 'kses_hook()' in case of 'WordPress':

    function kses_hook($string, &$cf, &$spec){
    // kses compatibility
    $allowed_html = $spec;
    $allowed_protocols = array();
    foreach($cf['schemes'] as $v){
     foreach($v as $k2=>$v2){
      if(!in_array($k2, $allowed_protocols)){
       $allowed_protocols[] = $k2;
      }
     }
    }
    return wp_kses_hook($string, $allowed_html, $allowed_protocols);
    // eof
    }


-- 2.7  Tolerance for ill-written HTML -----------------------------o


  htmLawed can work with ill-written HTML code in the input. However, HTML that is too ill-written may not be `read` as HTML, and be considered mere plain text instead. Following statements indicate the degree of `looseness` that htmLawed can work with, and can be provided in instructions to writers:

  *  Tags must be flanked by '<' and '>' with no '>' inside -- any needed '>' should be put in as '&gt;'. It is possible for tag content (element name and attributes) to be spread over many lines instead of being on one. A space may be present between the tag content and '>', like '<div >' and '<img / >', but not after the '<'.

  *  Element and attribute names need not be lower-cased.

  *  Attribute string of elements may be liberally spaced with tabs, line-breaks, etc.

  *  Attribute values may not be double-quoted, or may be single-quoted.

  *  Left-padding of numeric entities (like, '&#0160;', '&x07ff;') with '0' is okay as long as the number of characters between between the '&' and the ';' does not exceed 8. All entities must end with ';' though. 

  *  Named character entities must be properly cased. E.g., '&Lt;' or '&TILDE;' will not be let through without modification.

  *  HTML comments should not be inside element tags (okay between tags), and should begin with '<!--' and end with '-->'. Characters like '<', '>', and '&' may be allowed inside depending on '$config', but any '-->' inside should be put in as '--&gt;'. Any '--' inside will be automatically converted to '-', and a space will be added before the comment delimiter '-->'.

  *  'CDATA' sections should not be inside element tags, and can be in element content only if plain text is allowed for that element. They should begin with '<[CDATA[' and end with ']]>'. Characters like '<', '>', and '&' may be allowed inside depending on '$config', but any ']]>' inside should be put in as ']]&gt;'.

  *  For attribute values, character entities '&lt;', '&gt;' and '&amp;' should be used instead of characters '<' and '>', and '&' (when '&' is not part of a character entity). This applies even for Javascript code in values of attributes like 'onclick'.

  *  Characters '<', '>', '&' and '"' that are part of actual Javascript, etc., code in 'script' elements should be used as such and not be put in as entities like '&gt;'. Otherwise, though the HTML will be valid, the code may fail to work. Further, if such characters have to be used, then they should be put inside 'CDATA' sections.

  *  Simple instructions like "an opening tag cannot be present between two closing tags" and "nested elements should be closed in the reverse order of how they were opened" can help authors write balanced HTML. If tags are imbalanced, htmLawed will try to balance them, but in the process, depending on '$config["keep_bad"]', some code/text may be lost.

  *  Input authors should be notified of admin-specified allowed elements, attributes, configuration values (like conversion of named entities to numeric ones), etc.

  *  With '$config["unique_ids"]' not '0' and the 'id' attribute being permitted, writers should carefully avoid using duplicate or invalid 'id' values as even though htmLawed will correct/remove the values, the final output may not be the one desired. E.g., when '<a id="home"></a><input id="home" /><label for="home"></label>' is processed into 
'<a id="home"></a><input id="prefix_home" /><label for="home"></label>'.

  *  Note that even if intended HTML is lost in a highly ill-written input, the processed output will be more secure and standard-compliant.

  *  For URLs, unless '$config["scheme"]' is appropriately set, writers should avoid using escape characters or entities in schemes. E.g., 'htt&#112;' (which many browsers will read as the harmless 'http') may be considered bad by htmLawed.

  *  htmLawed will attempt to put plain text present directly inside 'blockquote', 'form', 'map' and 'noscript' elements (illegal as per the specs) inside auto-generated 'div' elements.


-- 2.8  Limitations & work-arounds ---------------------------------o


  htmLawed's main objective is to make the input text `more` standard-compliant, secure for web-page readers, and free of HTML elements and attributes considered undesirable by the administrator. Some of its current limitations, regardless of this objective, are noted below along with work-arounds.

  It should be borne in mind that no browser application is 100% standard-compliant, and that some of the standard specs (like asking for normalization of white-spacing within 'textarea' elements) are clearly wrong. Regarding security, note that `unsafe` HTML code is not necessarily legally invalid.

  *  htmLawed is meant for input that goes into the 'body' of HTML documents. HTML's head-level elements are not supported, nor are the frameset elements 'frameset', 'frame' and 'noframes'.

  *  It cannot transform the non-standard 'embed' elements to the standard-compliant 'object' elements. Yet, it can allow 'embed' elements if permitted ('embed' is widely used and supported). Admins can certainly use the 'hook_tag' parameter (section:- #3.4.9) to deploy a custom embed-to-object converter function.

  *  The only non-standard element that may be permitted is 'embed'; others like 'noembed' and 'nobr' cannot be permitted without modifying the htmLawed code.

  *  It cannot handle input that has non-HTML code like 'SVG' and 'MathML'. One way around is to break the input into pieces and passing only those without non-HTML code to htmLawed. Another is described in section:- #3.9. A third way may be to some how take advantage of the '$config["and_mark"]' parameter (see section:- #3.2).

  *  By default, htmLawed won't check many attribute values for standard compliance. E.g., 'width="20m"' with the dimension in non-standard 'm' is let through. Implementing universal and strict attribute value checks can make htmLawed slow and resource-intensive. Admins should look at the 'hook_tag' parameter (section:- #3.4.9) or '$spec' to enforce finer checks.

  *  The attributes, deprecated (which can be transformed too) or not, that it supports are largely those that are in the specs. Only a few of the proprietary attributes are supported.

  *  Except for contained URLs and dynamic expressions (also optional), htmLawed does not check CSS style property values. Admins should look at using the 'hook_tag' parameter (section:- #3.4.9) or '$spec' for finer checks. Perhaps the best option is to disallow 'style' but allow 'class' attributes with the right 'oneof' or 'match' values for 'class', and have the various class style properties in '.css' CSS stylesheet files.

  *  htmLawed does not parse emoticons, decode `BBcode`, or `wikify`, auto-converting text to proper HTML. Similarly, it won't convert line-breaks to 'br' elements. Such functions are beyond its purview. Admins should use other code to pre- or post-process the input for such purposes.

  *  htmLawed cannot be used to have links force-opened in new windows (by auto-adding appropriate 'target' and 'onclick' attributes to 'a'). Admins should look at Javascript-based DOM-modifying solutions for this. Admins may also be able to use a custom hook function to enforce such checks ('hook_tag' parameter; see section:- #3.4.9).

  *  Nesting-based checks are not possible. E.g., one cannot disallow 'p' elements specifically inside 'td' while permitting it elsewhere. Admins may be able to use a custom hook function to enforce such checks ('hook_tag' parameter; see section:- #3.4.9).

  *  Except for optionally converting absolute or relative URLs to the other type, htmLawed will not alter URLs (e.g., to change the value of query strings or to convert 'http' to 'https'. Having absolute URLs may be a standard-requirement, e.g., when HTML is embedded in email messages, whereas altering URLs for other purposes is beyond htmLawed's goals. Admins may be able to use a custom hook function to enforce such checks ('hook_tag' parameter; see section:- #3.4.9).

  *  Pairs of opening and closing tags that do not enclose any content (like '<em></em>') are not removed. This may be against the standard specs for certain elements (e.g., 'table'). However, presence of such standard-incompliant code will not break the display or layout of content. Admins can also use simple regex-based code to filter out such code.

  *  htmLawed does not check for certain element orderings described in the standard specs (e.g., in a 'table', 'tbody' is allowed before 'tfoot'). Admins may be able to use a custom hook function to enforce such checks ('hook_tag' parameter; see section:- #3.4.9).

  *  htmLawed does not check the number of nested elements. E.g., it will allow two 'caption' elements in a 'table' element, illegal as per the specs. Admins may be able to use a custom hook function to enforce such checks ('hook_tag' parameter; see section:- #3.4.9).

  *  htmLawed might convert certain entities to actual characters and remove backslashes and CSS comment-markers ('/*') in 'style' attribute values in order to detect malicious HTML like crafted IE-specific dynamic expressions like '&#101;xpression...'. If this is too harsh, admins can allow CSS expressions through htmLawed core but then use a custom function through the 'hook_tag' parameter (section:- #3.4.9) to more specifically identify CSS expressions in the 'style' attribute values. Also, using '$config["style_pass"]', it is possible to have htmLawed pass 'style' attribute values without even looking at them (section:- #3.4.8).

  *  htmLawed does not correct certain possible attribute-based security vulnerabilities (e.g., '<a href="http://x%22+style=%22background-image:xss">x</a>'). These arise when browsers mis-identify markup in `escaped` text, defeating the very purpose of escaping text (a bad browser will read the given example as '<a href="http://x" style="background-image:xss">x</a>').
  
  *  Because of poor Unicode support in PHP, htmLawed does not remove the `high value` HTML-invalid characters with multi-byte code-points. Such characters however are extremely unlikely to be in the input. (see section:- #3.1).

  *  Like any script using PHP's PCRE regex functions, PHP setup-specific low PCRE limit values can cause htmLawed to at least partially fail with very long input texts.


-- 2.9  Examples ---------------------------------------------------o


  *1.* A blog administrator wants to allow only 'a', 'em', 'strike', 'strong' and 'u' in comments, but needs 'strike' and 'u' transformed to 'span' for better XHTML 1-strict compliance, and, he wants the 'a' links to be to 'http' or 'https' resources:

    $processed = htmLawed($in, array('elements'=>'a, em, strike, strong, u', 'make_tag_strict'=>1, 'safe'=>1, 'schemes'=>'*:http, https'), 'a=href');

  *2.* An author uses a custom-made web application to load content on his web-site. He is the only one using that application and the content he generates has all types of HTML, including scripts. The web application uses htmLawed primarily as a tool to correct errors that creep in while writing HTML and to take care of the occasional `bad` characters in copy-paste text introduced by Microsoft Office. The web application provides a preview before submitted input is added to the content. For the previewing process, htmLawed is set up as follows:

    $processed = htmLawed($in, array('css_expression'=>1, 'keep_bad'=>1, 'make_tag_strict'=>1, 'schemes'=>'*:*', 'valid_xhtml'=>1));

  For the final submission process, 'keep_bad' is set to '6'. A value of '1' for the preview process allows the author to note and correct any HTML mistake without losing any of the typed text.

  *3.* A data-miner is scraping information in a specific table of similar web-pages and is collating the data rows, and uses htmLawed to reduce unnecessary markup and white-spaces:

    $processed = htmLawed($in, array('elements'=>'tr, td', 'tidy'=>-1), 'tr, td =');


== 3  Details =====================================================oo


-- 3.1  Invalid/dangerous characters --------------------------------


  Valid characters (more correctly, their code-points) in HTML or XML are, hexadecimally, '9', 'a', 'd', '20' to 'd7ff', and 'e000' to '10ffff', except 'fffe' and 'ffff' (decimally, '9', '10', '13', '32' to '55295', and '57344' to '1114111', except '65534' and '65535'). htmLawed removes the invalid characters '0' to '8', 'b', 'c', and 'e' to '1f'.

  Because of PHP's poor native support for multi-byte characters, htmLawed cannot check for the remaining invalid code-points. However, for various reasons, it is very unlikely for any of those characters to be in the input.

  Characters that are discouraged (see section:- #5.1) but not invalid are not removed by htmLawed.

  It (function 'hl_tag()') also replaces the potentially dangerous (in some Mozilla [Firefox] and Opera browsers) soft-hyphen character (code-point, hexadecimally, 'ad', or decimally, '173') in attribute values with spaces. Where required, the characters '<', '>', '&', and '"' are converted to entities.

  With '$config["clean_ms_char"]' set as '1' or '2', many of the discouraged characters (decimal code-points '127' to '159' except '133') that many Microsoft applications incorrectly use (as per the 'Windows 1252' ['Cp-1252'] or a similar encoding system), and the character for decimal code-point '133', are converted to appropriate decimal numerical entities (or removed for a few cases)-- see appendix in section:- #5.4. This can help avoid some display issues arising from copying-pasting of content.

  With '$config["clean_ms_char"]' set as '2', characters for the hexadecimal code-points '82', '91', and '92' (for special single-quotes), and '84', '93', and '94' (for special double-quotes) are converted to ordinary single and double quotes respectively and not to entities.

  The character values are replaced with entities/characters and not character values referred to by the entities/characters to keep this task independent of the character-encoding of input text.

  The '$config["clean_ms_char"]' parameter need not be used if authors do not copy-paste Microsoft-created text or if the input text is not believed to use the 'Windows 1252' or a similar encoding. Further, the input form and the web-pages displaying it or its content should have the character encoding appropriately marked-up.


-- 3.2  Character references/entities ------------------------------o


  Valid character entities take the form '&*;' where '*' is '#x' followed by a hexadecimal number (hexadecimal numeric entity; like '&#xA0;' for non-breaking space), or alphanumeric like 'gt' (external or named entity; like '&nbsp;' for non-breaking space), or '#' followed by a number (decimal numeric entity; like '&#160;' for non-breaking space). Character entities referring to the soft-hyphen character (the '&shy;' or '\xad' character; hexadecimal code-point 'ad' [decimal '173']) in attribute values are always replaced with spaces; soft-hyphens in attribute values introduce vulnerabilities in some older versions of the Opera and Mozilla [Firefox] browsers.

  htmLawed (function 'hl_ent()'):

  *  Neutralizes entities with multiple leading zeroes or missing semi-colons (potentially dangerous)

  *  Lowercases the 'X' (for XML-compliance) and 'A-F' of hexadecimal numeric entities

  *  Neutralizes entities referring to characters that are HTML-invalid (see section:- #3.1)

  *  Neutralizes entities referring to characters that are HTML-discouraged (code-points, hexadecimally, '7f' to '84', '86' to '9f', and 'fdd0' to 'fddf', or decimally, '127' to '132', '134' to '159', and '64991' to '64976'). Entities referring to the remaining discouraged characters (see section:- #5.1 for a full list) are let through.

  *  Neutralizes named entities that are not in the specs.

  *  Optionally converts valid HTML-specific named entities except '&gt;', '&lt;', '&quot;', and '&amp;' to decimal numeric ones (hexadecimal if $config["hexdec_entity"] is '2') for generic XML-compliance. For this, '$config["named_entity"]' should be '1'.

  *  Optionally converts hexadecimal numeric entities to the more widely supported decimal ones. For this, '$config["hexdec_entity"]' should be '0'.

  *  Optionally converts decimal numeric entities to the hexadecimal ones. For this, '$config["hexdec_entity"]' should be '2'.

  `Neutralization` refers to the `entitification` of '&' to '&amp;'.

  *Note*: htmLawed does not convert entities to the actual characters represented by them; one can pass the htmLawed output through PHP's 'html_entity_decode' function:- http://www.php.net/html_entity_decode for that.

  *Note*: If '$config["and_mark"]' is set, and set to a value other than '0', then the '&' characters in the original input are replaced with the control character for the hexadecimal code-point '6' ('\x06'; '&' characters introduced by htmLawed, e.g., after converting '<' to '&lt;', are not affected). This allows one to distinguish, say, an '&gt;' introduced by htmLawed and an '&gt;' put in by the input writer, and can be helpful in further processing of the htmLawed-processed text (e.g., to identify the character sequence 'o(><)o' to generate an emoticon image). When this feature is active, admins should ensure that the htmLawed output is not directly used in web pages or XML documents as the presence of the '\x06' can break documents. Before use in such documents, and preferably before any storage, any remaining '\x06' should be changed back to '&', e.g., with:

    $final = str_replace("\x06", '&', $prelim);

  Also, see section:- #3.9.


-- 3.3  HTML elements ----------------------------------------------o


  htmLawed can be configured to allow only certain HTML elements (tags) in the input. Disallowed elements (just tag-content, and not element-content), based on '$config["keep_bad"]', are either `neutralized` (converted to plain text by entitification of '<' and '>') or removed.

  E.g., with only 'em' permitted:

  Input:

      <em>My</em> website is <a href="http://a.com>a.com</a>.

  Output, with '$config["keep_bad"] = 0':

      <em>My</em> website is a.com.

  Output, with '$config["keep_bad"]' not '0':

      <em>My</em> website is &lt;a href=""&gt;a.com&lt;/a&gt;.

  See section:- #3.3.3 for differences between the various non-zero '$config["keep_bad"]' values.

  htmLawed by default permits these 86 elements:

    a, abbr, acronym, address, applet, area, b, bdo, big, blockquote, br, button, caption, center, cite, code, col, colgroup, dd, del, dfn, dir, div, dl, dt, em, embed, fieldset, font, form, h1, h2, h3, h4, h5, h6, hr, i, iframe, img, input, ins, isindex, kbd, label, legend, li, map, menu, noscript, object, ol, optgroup, option, p, param, pre, q, rb, rbc, rp, rt, rtc, ruby, s, samp, script, select, small, span, strike, strong, sub, sup, table, tbody, td, textarea, tfoot, th, thead, tr, tt, u, ul, var

  Except for 'embed' (included because of its wide-spread use) and the Ruby elements ('rb', 'rbc', 'rp', 'rt', 'rtc', 'ruby'; part of XHTML 1.1), these are all the elements in the HTML 4/XHTML 1 specs. Strict-specific specs. exclude 'center', 'dir', 'font', 'isindex', 'menu', 's', 'strike', and 'u'.

  With '$config["safe"] = 1', the default set will exclude 'applet', 'embed', 'iframe', 'object' and 'script'; see section:- #3.6.

  When '$config["elements"]', which specifies allowed elements, is `properly` defined, and neither empty nor set to '0' or '*', the default set is not used. To have elements added to or removed from the default set, a '+/-' notation is used. E.g., '*-script-object' implies that only 'script' and 'object' are disallowed, whereas '*+embed' means that 'noembed' is also allowed. Elements can also be specified as comma separated names. E.g., 'a, b, i' means only 'a', 'b' and 'i' are permitted. In this notation, '*', '+' and '-' have no significance and can actually cause a mis-reading.

  Some more examples of '$config["elements"]' values indicating permitted elements (note that empty spaces are liberally allowed for clarity):

  *  'a, blockquote, code, em, strong' -- only 'a', 'blockquote', 'code', 'em', and 'strong'
  *  '*-script' -- all excluding 'script'
  *  '* -center -dir -font -isindex -menu -s -strike -u' -- only XHTML-Strict elements
  *  '*+noembed-script' -- all including 'noembed' excluding 'script'

  Some mis-usages (and the resulting permitted elements) that can be avoided:

  *  '-*' -- none; instead of htmLawed, one might just use, e.g., the 'htmlspecialchars()' PHP function
  *  '*, -script' -- all except 'script'; admin probably meant '*-script'
  *  '-*, a, em, strong' -- all; admin probably meant 'a, em, strong'
  *  '*' -- all; admin need not have set 'elements'
  *  '*-form+form' -- all; a '+' will always over-ride any '-'
  *  '*, noembed' -- only 'noembed'; admin probably meant '*+noembed'
  *  'a, +b, i' -- only 'a' and 'i'; admin probably meant 'a, b, i'

  Basically, when using the '+/-' notation, commas (',') should not be used, and vice versa, and '*' should be used with the former but not the latter.

  *Note*: Even if an element that is not in the default set is allowed through '$config["elements"]', like 'noembed' in the last example, it will eventually be removed during tag balancing unless such balancing is turned off ('$config["balance"]' set to '0'). Currently, the only way around this, which actually is simple, is to edit the various arrays in the function 'hl_bal()' to accommodate the element and its nesting properties.

  *A possibly second way to specify allowed elements* is to set '$config["parent"]' to an element name that supposedly will hold the input, and to set '$config["balance"]' to '1'. During tag balancing (see section:- #3.3.3), all elements that cannot legally nest inside the parent element will be removed. The parent element is auto-reset to 'div' if '$config["parent"]' is empty, 'body', or an element not in htmLawed's default set of 86 elements.

  `Tag transformation` is possible for improving XHTML-Strict compliance -- most of the deprecated elements are removed or converted to valid XHTML-Strict ones; see section:- #3.3.2.


.. 3.3.1  Handling of comments and CDATA sections ...................


  'CDATA' sections have the format '<![CDATA[...anything but not "]]>"...]]>', and HTML comments, '<!--...anything but not "-->"... -->'. Neither HTML comments nor 'CDATA' sections can reside inside tags. HTML comments can exist anywhere else, but 'CDATA' sections can exist only where plain text is allowed (e.g., immediately inside 'td' element content but not immediately inside 'tr' element content).

  htmLawed (function 'hl_cmtcd()') handles HTML comments or 'CDATA' sections depending on the values of '$config["comment"]' or '$config["cdata"]'. If '0', such markup is not looked for and the text is processed like plain text. If '1', it is removed completely. If '2', it is preserved but any '<', '>' and '&' inside are changed to entities. If '3', they are left as such.

  Note that for the last two cases, HTML comments and 'CDATA' sections will always be removed from tag content (function 'hl_tag()').

  Examples:

  Input:
    <!-- home link --><a href="home.htm"><![CDATA[x=y]]>Home</a>
  Output ('$config["comment"] = 0, $config["cdata"] = 2'):
    &lt;-- home link --&gt;<a href="home.htm"><![CDATA[x=amp;y]]>Home</a>
  Output ('$config["comment"] = 1, $config["cdata"] = 2'):
    <a href="home.htm"><![CDATA[x=amp;y]]>Home</a>
  Output ('$config["comment"] = 2, $config["cdata"] = 2'):
    <!-- home link --><a href="home.htm"><![CDATA[x=amp;y]]>Home</a>
  Output ('$config["comment"] = 2, $config["cdata"] = 1'):
    <!-- home link --><a href="home.htm">Home</a>
  Output ('$config["comment"] = 3, $config["cdata"] = 3'):
    <!-- home link --><a href="home.htm"><![CDATA[x=y]]>Home</a>

  For standard-compliance, comments are given the form '<!--comment -->', and any '--' in the content is made '-'.

  When '$config["safe"] = 1', CDATA sections and comments are considered plain text unless '$config["comment"]' or '$config["cdata"]' is explicitly specified; see section:- #3.6.


.. 3.3.2  Tag-transformation for better XHTML-Strict ................o


  If '$config["make_tag_strict"]' is set and not '0', following non-XHTML-Strict elements (and attributes), even if admin-permitted, are mutated as indicated (element content remains intact; function 'hl_tag2()'):

  *  applet - (based on '$config["make_tag_strict"]', unchanged ('1') or removed ('2'))
  *  center - 'div style="text-align: center;"'
  *  dir - 'ul'
  *  embed - (based on '$config["make_tag_strict"]', unchanged ('1') or removed ('2'))
  *  font (face, size, color) -	'span style="font-family: ; font-size: ; color: ;"' (size transformation reference:- http://style.cleverchimp.com/font_size_intervals/altintervals.html)
  *  isindex - (based on '$config["make_tag_strict"]', unchanged ('1') or removed ('2'))
  *  menu - 'ul'
  *  s - 'span style="text-decoration: line-through;"'
  *  strike - 'span style="text-decoration: line-through;"'
  *  u - 'span style="text-decoration: underline;"'

  For an element with a pre-existing 'style' attribute value, the extra style properties are appended.

  Example input:

    <center>
     The PHP <s>software</s> script used for this <strike>web-page</strike> web-page is <font style="font-weight: bold " face=arial size='+3' color   =  "red  ">htmLawedTest.php</font>, from <u style= 'color:green'>PHP Labware</u>.
    </center>

  The output:

    <div style="text-align: center;">
     The PHP <span style="text-decoration: line-through;">software</span> script used for this <span style="text-decoration: line-through;">web-page</span> web-page is <span style="font-weight: bold; font-family: arial; color: red; font-size: 200%;">htmLawedTest.php</span>, from <span style="color:green; text-decoration: underline;">PHP Labware</span>.
    </div>


-- 3.3.3  Tag balancing and proper nesting -------------------------o


  If '$config["balance"]' is set to '1', htmLawed (function 'hl_bal()') checks and corrects the input to have properly balanced tags and legal element content (i.e., any element nesting should be valid, and plain text may be present only in the content of elements that allow them).

  Depending on the value of '$config["keep_bad"]' (see section:- #2.2 and section:- #3.3), illegal content may be removed or neutralized to plain text by converting < and > to entities:

  '0' - remove; this option is available only to maintain Kses-compatibility and should not be used otherwise (see section:- #2.6)
  '1' - neutralize tags and keep element content
  '2' - remove tags but keep element content
  '3' and '4' - like '1' and '2', but keep element content only if text ('pcdata') is valid in parent element as per specs
  '5' and '6' -  like '3' and '4', but line-breaks, tabs and spaces are left

  Example input (disallowing the 'p' element):

    <*> Pseudo-tags <*>
    <xml>Non-HTML tag xml</xml>
    <p>
    Disallowed tag p
    </p>
    <ul>Bad<li>OK</li></ul>

  The output with '$config["keep_bad"] = 1':

    &lt;*&gt; Pseudo-tags &lt;*&gt;
    &lt;xml&gt;Non-HTML tag xml&lt;/xml&gt;
    &lt;p&gt;
    Disallowed tag p
    &lt;/p&gt;
    <ul>Bad<li>OK</li></ul>

  The output with '$config["keep_bad"] = 3':

    &lt;*&gt; Pseudo-tags &lt;*&gt;
    &lt;xml&gt;Non-HTML tag xml&lt;/xml&gt;
    &lt;p&gt;
    Disallowed tag p
    &lt;/p&gt;
    <ul><li>OK</li></ul>

  The output with '$config["keep_bad"] = 6':

    &lt;*&gt; Pseudo-tags &lt;*&gt;
    Non-HTML tag xml
    
    Disallowed tag p
    
    <ul><li>OK</li></ul>

  An option like '1' is useful, e.g., when a writer previews his submission, whereas one like '3' is useful before content is finalized and made available to all.

  *Note:* In the example above, unlike '<*>', '<xml>' gets considered as a tag (even though there is no HTML element named 'xml'). In general, text matching the regular expression pattern '<(/?)([a-zA-Z][a-zA-Z1-6]*)([^>]*?)\s?>' is considered a tag (phrase enclosed by the angled brackets '<' and '>', and starting [with an optional slash preceding] with an alphanumeric word that starts with an alphabet...).

  Nesting/content rules for each of the 86 elements in htmLawed's default set (see section:- #3.3) are defined in function 'hl_bal()'. This means that if a non-standard element besides 'embed' is being permitted through '$config["elements"]', the element's tag content will end up getting removed if '$config["balance"]' is set to '1'.

  Plain text and/or certain elements nested inside 'blockquote', 'form', 'map' and 'noscript' need to be in block-level elements. This point is often missed during manual writing of HTML code. htmLawed attempts to address this during balancing. E.g., if the parent container is set as 'form', the input 'B:<input type="text" value="b" />C:<input type="text" value="c" />' is converted to '<div>B:<input type="text" value="b" />C:<input type="text" value="c" /></div>'.


-- 3.3.4  Elements requiring child elements ------------------------o


  As per specs, the following elements require legal child elements nested inside them:

    blockquote, dir, dl, form, map, menu, noscript, ol, optgroup, rbc, rtc, ruby, select, table, tbody, tfoot, thead, tr, ul

  In some cases, the specs stipulate the number and/or the ordering of the child elements. A 'table' can have 0 or 1 'caption', 'tbody', 'tfoot', and 'thead', but they must be in this order: 'caption', 'thead', 'tfoot', 'tbody'.

  htmLawed currently does not check for conformance to these rules. Note that any non-compliance in this regard will not introduce security vulnerabilities, crash browser applications, or affect the rendering of web-pages.


-- 3.3.5  Beautify or compact HTML ---------------------------------o


  By default, htmLawed will neither `beautify` HTML code by formatting it with indentations, etc., nor will it make it compact by removing un-needed white-space.(It does always properly white-space tag content.)

  As per the HTML standards, spaces, tabs and line-breaks in web-pages (except those inside 'pre' elements) are all considered equivalent, and referred to as `white-spaces`. Browser applications are supposed to consider contiguous white-spaces as just a single space, and to disregard white-spaces trailing opening tags or preceding closing tags. This white-space `normalization` allows the use of text/code beautifully formatted with indentations and line-spacings for readability. Such `pretty` HTML can, however, increase the size of web-pages, or make the extraction or scraping of plain text cumbersome.

  With the '$config' parameter 'tidy', htmLawed can be used to beautify or compact the input text. Input with just plain text and no HTML markup is also subject to this. Besides 'pre', the 'script' and 'textarea' elements, CDATA sections, and HTML comments are not subjected to the tidying process.

  To `compact`, use '$config["tidy"] = -1'; single instances or runs of white-spaces are replaced with a single space, and white-spaces trailing and leading open and closing tags, respectively, are removed.

  To `beautify`, '$config["tidy"]' is set as '1', or for customized tidying, as a string like '2s2n'. The 's' or 't' character specifies the use of spaces or tabs for indentation. The first and third characters, any of the digits 0-9, specify the number of spaces or tabs per indentation, and any parental lead spacing (extra indenting of the whole block of input text). The 'r' and 'n' characters are used to specify line-break characters: 'n' for '\n' (Unix/Mac OS X line-breaks), 'rn' or 'nr' for '\r\n' (Windows/DOS line-breaks), or 'r' for '\r'.

  The '$config["tidy"]' value of '1' is equivalent to '2s0n'. Other '$config["tidy"]' values are read loosely: a value of '4' is equivalent to '4s0n'; 't2', to '1t2n'; 's', to '2s0n'; '2TR', to '2t0r'; 'T1', to '1t1n'; 'nr3', to '3s0nr', and so on. Except in the indentations and line-spacings, runs of white-spaces are replaced with a single space during beautification.

  Input formatting using '$config["tidy"]' is not recommended when input text has mixed markup (like HTML + PHP).


-- 3.4  Attributes ------------------------------------------------oo


  htmLawed will only permit attributes described in the HTML specs (including deprecated ones). It also permits some attributes for use with the 'embed' element (the non-standard 'embed' element is supported in htmLawed because of its widespread use), and the the 'xml:space' attribute (valid only in XHTML 1.1). A list of such 111 attributes and the elements they are allowed in is in section:- #5.2.

  When '$config["deny_attribute"]' is not set, or set to '0', or empty ('""'), all the 111 attributes are permitted. Otherwise, '$config["deny_attribute"]' can be set as a list of comma-separated names of the denied attributes. 'on*' can be used to refer to the group of potentially dangerous, script-accepting attributes: 'onblur', 'onchange', 'onclick', 'ondblclick', 'onfocus', 'onkeydown', 'onkeypress', 'onkeyup', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onreset', 'onselect' and 'onsubmit'.

  Note that attributes specified in '$config["deny_attribute"]' are denied globally, for all elements. To deny attributes for only specific elements, '$spec' (see section:- #2.3) can be used. '$spec' can also be used to element-specifically permit an attribute otherwise denied through '$config["deny_attribute"]'.

  With '$config["safe"] = 1' (section:- #3.6), the 'on*' attributes are automatically disallowed.

  *Note*: To deny all but a few attributes globally, a simpler way to specify '$config["deny_attribute"]' would be to use the notation '* -attribute1 -attribute2 ...'. Thus, a value of '* -title -href' implies that except 'href' and 'title' (where allowed as per standards) all other attributes are to be removed. With this notation, the value for the parameter 'safe' (section:- #3.6) will have no effect on 'deny_attribute'.

  htmLawed (function 'hl_tag()') also:

  *  Lower-cases attribute names
  *  Removes duplicate attributes (last one stays)
  *  Gives attributes the form 'name="value"' and single-spaces them, removing unnecessary white-spacing
  *  Provides `required` attributes (see section:- #3.4.1)
  *  Double-quotes values and escapes any '"' inside them
  *  Replaces the possibly dangerous soft-hyphen characters (hexadecimal code-point 'ad') in the values with spaces
  *  Allows custom function to additionally filter/modify attribute values (see section:- #3.4.9)


.. 3.4.1  Auto-addition of XHTML-required attributes ................


  If indicated attributes for the following elements are found missing, htmLawed (function 'hl_tag()') will add them (with values same as attribute names unless indicated otherwise below):

  *  area - alt ('area')
  *  area, img - src, alt ('image')
  *  bdo - dir ('ltr')
  *  form - action
  *  map - name
  *  optgroup - label
  *  param - name
  *  script - type ('text/javascript')
  *  textarea - rows ('10'), cols ('50')

  Additionally, with '$config["xml:lang"]' set to '1' or '2', if the 'lang' but not the 'xml:lang' attribute is declared, then the latter is added too, with a value copied from that of 'lang'. This is for better standard-compliance. With '$config["xml:lang"]' set to '2', the 'lang' attribute is removed (XHTML 1.1 specs).

  Note that the 'name' attribute for 'map', invalid in XHTML 1.1, is also transformed if required -- see section:- #3.4.6.


.. 3.4.2  Duplicate/invalid 'id' values ............................o


  If '$config["unique_ids"]' is '1', htmLawed (function 'hl_tag()') removes 'id' attributes with values that are not XHTML-compliant (must begin with a letter and can contain letters, digits, ':', '.', '-' and '_') or duplicate. If '$config["unique_ids"]' is a word, any duplicate but otherwise valid value will be appropriately prefixed with the word to ensure its uniqueness. The word should begin with a letter and should contain only letters, numbers, ':', '.', '_' and '-'.

  Even if multiple inputs need to be filtered (through multiple calls to htmLawed), htmLawed ensures uniqueness of 'id' values as it uses a global variable ('$GLOBALS["hl_Ids"]' array). Further, an admin can restrict the use of certain 'id' values by presetting this variable before htmLawed is called into use. E.g.:

    $GLOBALS['hl_Ids'] = array('top'=>1, 'bottom'=>1, 'myform'=>1); // id values not allowed in input
    $processed = htmLawed($text); // filter input


.. 3.4.3  URL schemes (protocols) and scripts in attribute values ............o


  htmLawed edits attributes that take URLs as values if they are found to contain un-permitted schemes. E.g., if the 'afp' scheme is not permitted, then '<a href="afp://domain.org">' becomes '<a href="denied:afp://domain.org">', and if Javascript is not permitted '<a onclick="javascript:xss();">' becomes '<a onclick="denied:javascript:xss();">'.

  By default htmLawed permits these schemes in URLs for the 'href' attribute:

    aim, feed, file, ftp, gopher, http, https, irc, mailto, news, nntp, sftp, ssh, telnet

  Also, only 'file', 'http' and 'https' are permitted in attributes whose names start with 'o' (like 'onmouseover'), and in these attributes that accept URLs:

    action, cite, classid, codebase, data, href, longdesc, model, pluginspage, pluginurl, src, style, usemap

  These default sets are used when '$config["schemes"]' is not set (see section:- #2.2). To over-ride the defaults, '$config["schemes"]' is defined as a string of semi-colon-separated sub-strings of type 'attribute: comma-separated schemes'. E.g., 'href: mailto, http, https; onclick: javascript; src: http, https'. For unspecified attributes, 'file', 'http' and 'https' are permitted. This can be changed by passing schemes for '*' in '$config["schemes"]'. E.g., 'href: mailto, http, https; *: https, https'.

  '*' can be put in the list of schemes to permit all protocols. E.g., 'style: *; img: http, https' results in protocols not being checked in 'style' attribute values. However, in such cases, any relative-to-absolute URL conversion, or vice versa, (section:- #3.4.4) is not done.

  Thus, `to allow Javascript`, one can set '$config["schemes"]' as 'href: mailto, http, https; *: http, https, javascript', or 'href: mailto, http, https, javascript; *: http, https, javascript', or '*: *', and so on.

  As a side-note, one may find 'style: *' useful as URLs in 'style' attributes can be specified in a variety of ways, and the patterns that htmLawed uses to identify URLs may mistakenly identify non-URL text.

  *Note*: If URL-accepting attributes other than those listed above are being allowed, then the scheme will not be checked unless the attribute name contains the string 'src' (e.g., 'dynsrc') or starts with 'o' (e.g., 'onbeforecopy').

  With '$config["safe"] = 1', all URLs are disallowed in the 'style' attribute values.


.. 3.4.4  Absolute & relative URLs in attribute values .............o


  htmLawed can make absolute URLs in attributes like 'href' relative ('$config["abs_url"]' is '-1'), and vice versa ('$config["abs_url"]' is '1'). URLs in scripts are not considered for this, and so are URLs like '#section_6' (fragment), '?name=Tim#show' (starting with query string), and ';var=1?name=Tim#show' (starting with parameters). Further, this requires that '$config["base_url"]' be set properly, with the '://' and a trailing slash ('/'), with no query string, etc. E.g., 'file:///D:/page/', 'https://abc.com/x/y/', or 'http://localhost/demo/' are okay, but 'file:///D:/page/?help=1', 'abc.com/x/y/' and 'http://localhost/demo/index.htm' are not.

  For making absolute URLs relative, only those URLs that have the '$config["base_url"]' string at the beginning are converted. E.g., with '$config["base_url"] = "https://abc.com/x/y/"', 'https://abc.com/x/y/a.gif' and 'https://abc.com/x/y/z/b.gif' become 'a.gif' and 'z/b.gif' respectively, while 'https://abc.com/x/c.gif' is not changed.

  When making relative URLs absolute, only values for scheme, network location (host-name) and path values in the base URL are inherited. See section:- #5.5 for more about the URL specification as per RFC 1808:- http://www.ietf.org/rfc/rfc1808.txt.


.. 3.4.5  Lower-cased, standard attribute values ....................o


  Optionally, for standard-compliance, htmLawed (function 'hl_tag()') lower-cases standard attribute values to give, e.g., 'input type="password"' instead of 'input type="Password"', if '$config["lc_std_val"]' is '1'. Attribute values matching those listed below for any of the elements (plus those for the 'type' attribute of 'button' or 'input') are lower-cased:

    all, baseline, bottom, button, center, char, checkbox, circle, col, colgroup, cols, data, default, file, get, groups, hidden, image, justify, left, ltr, middle, none, object, password, poly, post, preserve, radio, rect, ref, reset, right, row, rowgroup, rows, rtl, submit, text, top

    a, area, bdo, button, col, form, img, input, object, option, optgroup, param, script, select, table, td, tfoot, th, thead, tr, xml:space

  The following `empty` (`minimized`) attributes are always assigned lower-cased values (same as the names):

    checked, compact, declare, defer, disabled, ismap, multiple, nohref, noresize, noshade, nowrap, readonly, selected


.. 3.4.6  Transformation of deprecated attributes ..................o


  If '$config["no_deprecated_attr"]' is '0', then deprecated attributes (see appendix in section:- #5.2) are removed and, in most cases, their values are transformed to CSS style properties and added to the 'style' attributes (function 'hl_tag()'). Except for 'bordercolor' for 'table', 'tr' and 'td', the scores of proprietary attributes that were never part of any cross-browser standard are not supported.

  *Note*: The attribute 'target' for 'a' is allowed even though it is not in XHTML 1.0 specs. This is because of the attribute's wide-spread use and browser-support, and because the attribute is valid in XHTML 1.1 onwards.

  *  align - for 'img' with value of 'left' or 'right', becomes, e.g., 'float: left'; for 'div' and 'table' with value 'center', becomes 'margin: auto'; all others become, e.g., 'text-align: right'

  *  bgcolor - E.g., 'bgcolor="#ffffff"' becomes 'background-color: #ffffff'
  *  border - E.g., 'height= "10"' becomes 'height: 10px'
  *  bordercolor - E.g., 'bordercolor=#999999' becomes 'border-color: #999999;'
  *  compact - 'font-size: 85%'
  *  clear - E.g., 'clear="all" becomes 'clear: both'

  *  height - E.g., 'height= "10"' becomes 'height: 10px' and 'height="*"' becomes 'height: auto'

  *  hspace - E.g., 'hspace="10"' becomes 'margin-left: 10px; margin-right: 10px'
  *  language - 'language="VBScript"' becomes 'type="text/vbscript"'
  *  name - E.g., 'name="xx"' becomes 'id="xx"'
  *  noshade - 'border-style: none; border: 0; background-color: gray; color: gray'
  *  nowrap - 'white-space: nowrap'
  *  size - E.g., 'size="10"' becomes 'height: 10px'
  *  start - removed
  *  type - E.g., 'type="i"' becomes 'list-style-type: lower-roman'
  *  value - removed
  *  vspace - E.g., 'vspace="10"' becomes 'margin-top: 10px; margin-bottom: 10px'
  *  width - like 'height'

  Example input:

    <img src="j.gif" alt="image" name="dad's" /><img src="k.gif" alt="image" id="dad_off" name="dad" />
    <br clear="left" />
    <hr noshade size="1" />
    <img name="img" src="i.gif" align="left" alt="image" hspace="10" vspace="10" width="10em" height="20" border="1" style="padding:5px;" />
    <table width="50em" align="center" bgcolor="red">
     <tr>
      <td width="20%">
       <div align="center">
        <h3 align="right">Section</h3>
        <p align="right">Para</p>
        <ol type="a" start="e"><li value="x">First item</li></ol>
       </div>
      </td>
      <td width="*">
       <ol type="1"><li>First item</li></ol>
      </td>
     </tr>
    </table>
    <br clear="all" />

  And the output with '$config["no_deprecated_attr"] = 1':

    <img src="j.gif" alt="image" /><img src="k.gif" alt="image" id="dad_off" />
    <br style="clear: left;" />
    <hr style="border-style: none; border: 0; background-color: gray; color: gray; size: 1px;" />
    <img src="i.gif" alt="image" width="10em" height="20" style="padding:5px; float: left; margin-left: 10px; margin-right: 10px; margin-top: 10px; margin-bottom: 10px; border: 1px;" id="img" />
    <table width="50em" style="margin: auto; background-color: red;">
     <tr>
      <td style="width: 20%;">
       <div style="margin: auto;">
        <h3 style="text-align: right;">Section</h3>
        <p style="text-align: right;">Para</p>
        <ol style="list-style-type: lower-latin;"><li>First item</li></ol>
       </div>
      </td>
      <td style="width: auto;">
       <ol style="list-style-type: decimal;"><li>First item</li></ol>
      </td>
     </tr>
    </table>
    <br style="clear: both;" />

  For 'lang', deprecated in XHTML 1.1, transformation is taken care of through '$config["xml:lang"]'; see section:- #3.4.1.

  The attribute 'name' is deprecated in 'form', 'iframe', and 'img', and is replaced with 'id' if an 'id' attribute doesn't exist and if the 'name' value is appropriate for 'id'. For such replacements for 'a' and 'map', for which the 'name' attribute is deprecated in XHTML 1.1, '$config["no_deprecated_attr"]' should be set to '2' (when set to '1', for these two elements, the 'name' attribute is retained).


-- 3.4.7  Anti-spam & 'href' ---------------------------------------o


  htmLawed (function 'hl_tag()') can check the 'href' attribute values (link addresses) as an anti-spam (email or link spam) measure.

  If '$config["anti_mail_spam"]' is not '0', the '@' of email addresses in 'href' values like 'mailto:a@b.com' is replaced with text specified by '$config["anti_mail_spam"]'. The text should be of a form that makes it clear to others that the address needs to be edited before a mail is sent; e.g., '<remove_this_antispam>@' (makes the example address 'a<remove_this_antispam>@b.com').

  For regular links, one can choose to have a 'rel' attribute with 'nofollow' in its value (which tells some search engines to not follow a link). This can discourage link spammers. Additionally, or as an alternative, one can choose to empty the 'href' value altogether (disable the link).

  For use of these options, '$config["anti_link_spam"]' should be set as an array with values 'regex1' and 'regex2', both or one of which can be empty (like 'array("", "regex2")') to indicate that that option is not to be used. Otherwise, 'regex1' or 'regex2' should be PHP- and PCRE-compatible regular expression patterns: 'href' values will be matched against them and those matching the pattern will accordingly be treated.

  Note that the regular expressions should have `delimiters`, and be well-formed and preferably fast. Absolute efficiency/accuracy is often not needed.

  An example, to have a 'rel' attribute with 'nofollow' for all links, and to disable links that do not point to domains 'abc.com' and 'xyz.org':

    $config["anti_link_spam"] = array('`.`', '`://\W*(?!(abc\.com|xyz\.org))`');


-- 3.4.8  Inline style properties ----------------------------------o


  htmLawed can check URL schemes and dynamic expressions (to guard against Javascript, etc., script-based insecurities) in inline CSS style property values in the 'style' attributes. (CSS properties like 'background-image' that accept URLs in their values are noted in section:- #5.3.) Dynamic CSS expressions that allow scripting in the IE browser, and can be a vulnerability, can be removed from property values by setting '$config["css_expression"]' to '1' (default setting).

  *Note*: Because of the various ways of representing characters in attribute values (URL-escapement, entitification, etc.), htmLawed might alter the values of the 'style' attribute values, and may even falsely identify dynamic CSS expressions and URL schemes in them. If this is an important issue, checking of URLs and dynamic expressions can be turned off ('$config["schemes"] = "...style:*..."', see section:- #3.4.3, and '$config["css_expression"] = 0'). Alternately, admins can use their own custom function for finer handling of 'style' values through the 'hook_tag' parameter (see section:- #3.4.9).

  It is also possible to have htmLawed let through any 'style' value by setting '$config["style_pass"]' to '1'.

  As such, it is better to set up a CSS file with class declarations, disallow the 'style' attribute, set a '$spec' rule (see section:- #2.3) for 'class' for the 'oneof' or 'match' parameter, and ask writers to make use of the 'class' attribute.


-- 3.4.9  Hook function for tag content ----------------------------o


  It is possible to utilize a custom hook function to alter the tag content htmLawed has finalized (i.e., after it has checked/corrected for required attributes, transformed attributes, lower-cased attribute names, etc.).

  When '$config' parameter 'hook_tag' is set to the name of a function, htmLawed (function 'hl_tag()') will pass on the element name, and the `finalized` attribute name-value pairs as array elements to the function. The function is expected to return the full opening tag string like '<element_name attribute_1_name="attribute_1_value"...>' (for empty elements like 'img' and 'input', the element-closing slash '/' should also be included).

  This is a *powerful functionality* that can be exploited for various objectives: consolidate-and-convert inline 'style' attributes to 'class', convert 'embed' elements to 'object', permit only one 'caption' element in a 'table' element, disallow embedding of certain types of media, *inject HTML*, use CSSTidy:- http://csstidy.sourceforge.net to sanitize 'style' attribute values, etc.

  As an example, the custom hook code below can be used to force a series of specifically ordered 'id' attributes on all elements, and a specific 'param' element inside all 'object' elements:

    function my_tag_function($element, $attribute_array){
      static $id = 0;
      // Remove any duplicate element
      if($element == 'param' && isset($attribute_array['allowscriptaccess'])){
        return '';
      }

      $new_element = '';

      // Force a serialized ID number
      $attribute_array['id'] = 'my_'. $id;
      ++$id;

      // Inject param for allowscriptaccess
      if($element == 'object'){
        $new_element = '<param id='my_'. $id; allowscriptaccess="never" />';
        ++$id;
      }

      $string = '';
      foreach($attribute_array as $k=>$v){
        $string .= " {$k}=\"{$v}\"";
      }
      return "<{$element}{$string}". (isset($in_array($element, $empty_elements) ? ' /' : ''). '>'. $new_element;
    }

  The 'hook_tag' parameter is different from the 'hook' parameter (section:- #3.7).

  Snippets of hook function code developed by others may be available on the htmLawed:- http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed website.


-- 3.5  Simple configuration directive for most valid XHTML -------oo


  If '$config["valid_xhtml"]' is set to '1', some relevant '$config' parameters (indicated by '~' in section:- #2.2) are auto-adjusted. This allows one to pass the '$config' argument with a simpler value. If a value for a parameter auto-set through 'valid_xhtml' is still manually provided, then that value will over-ride the auto-set value.


-- 3.6  Simple configuration directive for most `safe` HTML --------o


  `Safe` HTML refers to HTML that is restricted to reduce the vulnerability for scripting attacks (such as XSS) based on HTML code which otherwise may still be legal and compliant with the HTML standard specs. When elements such as 'script' and 'object', and attributes such as 'onmouseover' and 'style' are allowed in the input text, an input writer can introduce malevolent HTML code. Note that what is considered 'safe' depends on the nature of the web application and the trust-level accorded to its users.

  htmLawed allows an admin to use '$config["safe"]' to auto-adjust multiple '$config' parameters (such as 'elements' which declares the allowed element-set), which otherwise would have to be manually set. The relevant parameters are indicated by '"' in section:- #2.2). Thus, one can pass the '$config' argument with a simpler value.

  With the value of '1', htmLawed considers 'CDATA' sections and HTML comments as plain text, and prohibits the 'applet', 'embed', 'iframe', 'object' and 'script' elements, and the 'on*' attributes like 'onclick'. ( There are '$config' parameters like 'css_expression' that are not affected by the value set for 'safe' but whose default values still contribute towards a more `safe` output.) Further, URLs with schemes (see section:- #3.4.3) are neutralized so that, e.g., 'style="moz-binding:url(http://danger)"' becomes 'style="moz-binding:url(denied:http://danger)"' while 'style="moz-binding:url(ok)"' remains intact.

  Admins, however, may still want to completely deny the 'style' attribute, e.g., with code like

    $processed = htmLawed($text, array('safe'=>1, 'deny_attribute'=>'style'));

  If a value for a parameter auto-set through 'safe' is still manually provided, then that value can over-ride the auto-set value. E.g., with '$config["safe"] = 1' and '$config["elements"] = "*+script"', 'script', but not 'applet', is allowed.

  A page illustrating the efficacy of htmLawed's anti-XSS abilities with 'safe' set to '1' against XSS vectors listed by RSnake:- http://ha.ckers.org/xss.html may be available here:- http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/rsnake/RSnakeXSSTest.htm.


-- 3.7  Using a hook function --------------------------------------o


  If '$config["hook"]' is not set to '0', then htmLawed will allow preliminarily processed input to be altered by a hook function named by '$config["hook"]' before starting the main work (but after handling of characters, entities, HTML comments and 'CDATA' sections -- see code for function 'htmLawed()').

  The hook function also allows one to alter the `finalized` values of '$config' and '$spec'.

  Note that the 'hook' parameter is different from the 'hook_tag' parameter (section:- #3.4.9).

  Snippets of hook function code developed by others may be available on the htmLawed:- http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed website.


-- 3.8  Obtaining `finalized` parameter values ---------------------o


  htmLawed can assign the `finalized` '$config' and '$spec' values to a variable named by '$config["show_setting"]'. The variable, made global by htmLawed, is set as an array with three keys: 'config', with the '$config' value, 'spec', with the '$spec' value, and 'time', with a value that is the Unix time (the output of PHP's 'microtime()' function) when the value was assigned. Admins should use a PHP-compliant variable name (e.g., one that does not begin with a numerical digit) that does not conflict with variable names in their non-htmLawed code.

  The values, which are also post-hook function (if any), can be used to auto-generate information (on, e.g., the elements that are permitted) for input writers.


-- 3.9  Retaining non-HTML tags in input with mixed markup ---------o


  htmLawed does not remove certain characters that though invalid are nevertheless discouraged in HTML documents as per the specs (see section:- #5.1). This can be utilized to deal with input that contains mixed markup. Input that may have HTML markup as well as some other markup that is based on the '<', '>' and '&' characters is considered to have mixed markup. The non-HTML markup can be rather proprietary (like markup for emoticons/smileys), or standard (like MathML or SVG). Or it can be programming code meant for execution/evaluation (such as embedded PHP code).

  To deal with such mixed markup, the input text can be pre-processed to hide the non-HTML markup by specifically replacing the '<', '>' and '&' characters with some of the HTML-discouraged characters (see section:- #3.1.2). Post-htmLawed processing, the replacements are reverted.

  An example (mixed HTML and PHP code in input text):

    $text = preg_replace('`<\?php(.+?)\?>`sm', "\x83?php\\1?\x84", $text);
    $processed = htmLawed($text);
    $processed = preg_replace('`\x83\?php(.+?)\?\x84`sm', '<?php$1?>', $processed);

  This code will not work if '$config["clean_ms_char"]' is set to '1' (section:- #3.1), in which case one should instead deploy a hook function (section:- #3.7). (htmLawed internally uses certain control characters, code-points '1' to '7', and use of these characters as markers in the logic of hook functions may cause issues.)

  Admins may also be able to use '$config["and_mark"]' to deal with such mixed markup; see section:- #3.2.
 

== 4  Other =======================================================oo


-- 4.1  Support -----------------------------------------------------


  A careful re-reading of this documentation will very likely answer your questions.

  Software updates and forum-based community-support may be found at http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed. For general PHP issues (not htmLawed-specific), support may be found through internet searches and at http://php.net.


-- 4.2  Known issues -----------------------------------------------o


  See section:- #2.8.

  Readers are advised to cross-check information given in this document.


-- 4.3  Change-log -------------------------------------------------o


  (The release date for the downloadable package of files containing documentation, demo script, test-cases, etc., besides the 'htmLawed.php' file may be updated independently if the secondary files are revised.)

  `Version number - Release date. Notes`
  
  1.1.8 - 23 April 2009. Parameter 'deny_attribute' now accepts the wild-card '*', making it simpler to specify its value when all but a few attributes are being denied; fixed a bug in interpreting '$spec'

  1.1.7 - 11-12 March 2009. Attributes globally denied through 'deny_attribute' can be allowed element-specifically through '$spec'; '$config["style_pass"]' allowing letting through any 'style' value introduced; altered logic to catch certain types of dynamic crafted CSS expressions

  1.1.3-6 - 28-31 January - 4 February 2009. Altered logic to catch certain types of dynamic crafted CSS expressions

  1.1.2 - 22 January 2009. Fixed bug in parsing of 'font' attributes during tag transformation
  
  1.1.1 - 27 September 2008. Better nesting correction when omitable closing tags are absent

  1.1 - 29 June 2008. '$config["hook_tag"]' and '$config["format"]' introduced for custom tag/attribute check/modification/injection and output compaction/beautification; fixed a regex-in-$spec parsing bug

  1.0.9 - 11 June 2008. Fixed bug in invalid HTML code-point entity check

  1.0.8 - 15 May 2008. 'bordercolor' attribute for 'table', 'td' and 'tr'

  1.0.7 - 1 May 2008. Support for 'wmode' attribute for 'embed'; '$config["show_setting"]' introduced; improved '$config["elements"]' evaluation

  1.0.6 - 20 April 2008. '$config["and_mark"]' introduced

  1.0.5 - 12 March 2008. 'style' URL schemes essentially disallowed when $config 'safe' is on; improved regex for CSS expression search

  1.0.4 - 10 March 2008. Improved corrections for 'blockquote', 'form', 'map' and 'noscript'

  1.0.3 - 3 March 2008. Character entities for soft-hyphens are now replaced with spaces (instead of being removed); a bug allowing 'td' directly inside 'table' fixed; 'safe' '$config' parameter added

  1.0.2 - 13 February 2008. Improved implementation of '$config["keep_bad"]'

  1.0.1 - 7 November 2007. Improved regex for identifying URLs, protocols and dynamic expressions ('hl_tag()' and 'hl_prot()'); no error display with 'hl_regex()'

  1.0 - 2 November 2007. First release


-- 4.4  Testing ----------------------------------------------------o


  To test htmLawed using a form interface, a demo:- htmLawedTest.php web-page is provided with the htmLawed distribution ('htmLawed.php' and 'htmLawedTest.php' should be in the same directory on the web-server). A file with test-cases:- htmLawed_TESTCASE.txt is also provided.


-- 4.5  Upgrade, & old versions ------------------------------------o


  Upgrading is as simple as replacing the previous version of 'htmLawed.php' (assuming it was not modified for customized features). As htmLawed output is almost always used in static documents, upgrading should not affect old, finalized content.

  Old versions of htmLawed may be available online. E.g., for version 1.0, check http://www.bioinformatics.org/phplabware/downloads/htmLawed1.zip, for 1.1.1, htmLawed111.zip, and for 1.1.10, htmLawed1110.zip.


-- 4.6  Comparison with 'HTMLPurifier' -----------------------------o


  The HTMLPurifier PHP library by Edward Yang is a very good HTML filtering script that uses object oriented PHP code. Compared to htmLawed, it:

  *  does not support PHP versions older than 5.0 (HTMLPurifier dropped PHP 4 support after version 2)

  *  is 15-20 times bigger (scores of files totalling more than 750 kb)

  *  consumes 10-15 times more RAM memory (just including the HTMLPurifier files without calling the filter requires a few MBs of memory)

  *  is expectedly slower

  *  does not allow admins to fully allow all valid HTML (because of incomplete HTML support, it always considers elements like 'script' illegal)

  *  lacks many of the extra features of htmLawed (like entity conversions and code compaction/beautification)

  *  has poor documentation

  However, HTMLPurifier has finer checks for character encodings and attribute values, and can log warnings and errors. Visit the HTMLPurifier website:- http://htmlpurifier.org for updated information.


-- 4.7  Use through application plug-ins/modules -------------------o


  Plug-ins/modules to implement htmLawed in applications such as Drupal and DokuWiki may have been developed. Please check the application websites and the forum on the htmLawed site:- http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed.


-- 4.8  Use in non-PHP applications --------------------------------o


  Non-PHP applications written in Python, Ruby, etc., may be able to use htmLawed through system calls to the PHP engine. Such code may have been documented on the internet. Also check the forum on the htmLawed site:- http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed.


-- 4.9  Donate -----------------------------------------------------o


  A donation in any currency and amount to appreciate or support this software can be sent by PayPal:- http://paypal.com to this email address: drpatnaik at yahoo dot com.


-- 4.10  Acknowledgements ------------------------------------------o


  Bryan Blakey, Ulf Harnhammer, Gareth Heyes, Lukasz Pilorz, Shelley Powers, Edward Yang, and many anonymous users.

  Thank you!


== 5  Appendices ==================================================oo


-- 5.1  Characters discouraged in XHTML -----------------------------


  Characters represented by the following hexadecimal code-points are `not` invalid, even though some validators may issue messages stating otherwise.

  '7f' to '84', '86' to '9f', 'fdd0' to 'fddf', '1fffe', '1ffff', '2fffe', '2ffff', '3fffe', '3ffff', '4fffe', '4ffff', '5fffe', '5ffff', '6fffe', '6ffff', '7fffe', '7ffff', '8fffe', '8ffff', '9fffe', '9ffff', 'afffe', 'affff', 'bfffe', 'bffff', 'cfffe', 'cffff', 'dfffe', 'dffff', 'efffe', 'effff', 'ffffe', 'fffff', '10fffe' and '10ffff'


-- 5.2  Valid attribute-element combinations -----------------------o


  Valid attribute-element combinations as per W3C specs.

  *  includes deprecated attributes (marked '^'), attributes for the non-standard 'embed' element (marked '*'), and the proprietary 'bordercolor' (marked '~')
  *  only non-frameset, HTML body elements
  *  'name' for 'a' and 'map', and 'lang' are invalid in XHTML 1.1
  *  'target' is valid for 'a' in XHTML 1.1 and higher
  *  'xml:space' is only for XHTML 1.1

  abbr - td, th
  accept - form, input
  accept-charset - form
  accesskey - a, area, button, input, label, legend, textarea
  action - form
  align - caption^, embed, applet, iframe, img^, input^, object^, legend^, table^, hr^, div^, h1^, h2^, h3^, h4^, h5^, h6^, p^, col, colgroup, tbody, td, tfoot, th, thead, tr
  alt - applet, area, img, input
  archive - applet, object
  axis - td, th
  bgcolor - embed, table^, tr^, td^, th^
  border - table, img^, object^
  bordercolor~ - table, td, tr
  cellpadding - table
  cellspacing - table
  char - col, colgroup, tbody, td, tfoot, th, thead, tr
  charoff - col, colgroup, tbody, td, tfoot, th, thead, tr
  charset - a, script
  checked - input
  cite - blockquote, q, del, ins
  classid - object
  clear - br^
  code - applet
  codebase - object, applet
  codetype - object
  color - font
  cols - textarea
  colspan - td, th
  compact - dir, dl^, menu, ol^, ul^
  coords - area, a
  data - object
  datetime - del, ins
  declare - object
  defer - script
  dir - bdo
  disabled - button, input, optgroup, option, select, textarea
  enctype - form
  face - font
  for - label
  frame - table
  frameborder - iframe
  headers - td, th
  height - embed, iframe, td^, th^, img, object, applet
  href - a, area
  hreflang - a
  hspace - applet, img^, object^
  ismap - img, input
  label - option, optgroup
  language - script^
  longdesc - img, iframe
  marginheight - iframe
  marginwidth - iframe
  maxlength - input
  method - form
  model* - embed
  multiple - select
  name - button, embed, textarea, applet^, select, form^, iframe^, img^, a^, input, object, map^, param
  nohref - area
  noshade - hr^
  nowrap - td^, th^
  object - applet
  onblur - a, area, button, input, label, select, textarea
  onchange - input, select, textarea
  onfocus - a, area, button, input, label, select, textarea
  onreset - form
  onselect - input, textarea
  onsubmit - form
  pluginspage* - embed
  pluginurl* - embed
  prompt - isindex
  readonly - textarea, input
  rel - a
  rev - a
  rows - textarea
  rowspan - td, th
  rules - table
  scope - td, th
  scrolling - iframe
  selected - option
  shape - area, a
  size - hr^, font, input, select
  span - col, colgroup
  src - embed, script, input, iframe, img
  standby - object
  start - ol^
  summary - table
  tabindex - a, area, button, input, object, select, textarea
  target - a^, area, form
  type - a, embed, object, param, script, input, li^, ol^, ul^, button
  usemap - img, input, object
  valign - col, colgroup, tbody, td, tfoot, th, thead, tr
  value - input, option, param, button, li^
  valuetype - param
  vspace - applet, img^, object^
  width - embed, hr^, iframe, img, object, table, td^, th^, applet, col, colgroup, pre^
  wmode - embed
  xml:space - pre, script, style

  These are allowed in all but the shown elements:

  class - param, script
  dir - applet, bdo, br, iframe, param, script
  id - script
  lang - applet, br, iframe, param, script
  onclick - applet, bdo, br, font, iframe, isindex, param, script
  ondblclick - applet, bdo, br, font, iframe, isindex, param, script
  onkeydown - applet, bdo, br, font, iframe, isindex, param, script
  onkeypress - applet, bdo, br, font, iframe, isindex, param, script
  onkeyup - applet, bdo, br, font, iframe, isindex, param, script
  onmousedown - applet, bdo, br, font, iframe, isindex, param, script
  onmousemove - applet, bdo, br, font, iframe, isindex, param, script
  onmouseout - applet, bdo, br, font, iframe, isindex, param, script
  onmouseover - applet, bdo, br, font, iframe, isindex, param, script
  onmouseup - applet, bdo, br, font, iframe, isindex, param, script
  style - param, script
  title - param, script
  xml:lang - applet, br, iframe, param, script


-- 5.3  CSS 2.1 properties accepting URLs ------------------------o


  background
  background-image
  content
  cue-after
  cue-before
  cursor
  list-style
  list-style-image
  play-during


-- 5.4  Microsoft Windows 1252 character replacements --------------o


  Key: 'd' double, 'l' left, 'q' quote, 'r' right, 's.' single

  Code-point (decimal) - hexadecimal value - replacement entity - represented character

  127 - 7f - (removed) - (not used)
  128 - 80 - &#8364; - euro
  129 - 81 - (removed) - (not used)
  130 - 82 - &#8218; - baseline s. q
  131 - 83 - &#402; - florin
  132 - 84 - &#8222; - baseline d q
  133 - 85 - &#8230; - ellipsis
  134 - 86 - &#8224; - dagger
  135 - 87 - &#8225; - d dagger
  136 - 88 - &#710; - circumflex accent
  137 - 89 - &#8240; - permile
  138 - 8a - &#352; - S Hacek
  139 - 8b - &#8249; - l s. guillemet
  140 - 8c - &#338; - OE ligature
  141 - 8d - (removed) - (not used)
  142 - 8e - &#381; - Z dieresis
  143 - 8f - (removed) - (not used)
  144 - 90 - (removed) - (not used)
  145 - 91 - &#8216; - l s. q
  146 - 92 - &#8217; - r s. q
  147 - 93 - &#8220; - l d q
  148 - 94 - &#8221; - r d q
  149 - 95 - &#8226; - bullet
  150 - 96 - &#8211; - en dash
  151 - 97 - &#8212; - em dash
  152 - 98 - &#732; - tilde accent
  153 - 99 - &#8482; - trademark
  154 - 9a - &#353; - s Hacek
  155 - 9b - &#8250; - r s. guillemet
  156 - 9c - &#339; - oe ligature
  157 - 9d - (removed) - (not used)
  158 - 9e - &#382; - z dieresis
  159 - 9f - &#376; - Y dieresis


-- 5.5  URL format -------------------------------------------------o


  An `absolute` URL has a 'protocol' or 'scheme', a 'network location' or 'hostname', and, optional 'path', 'parameters', 'query' and 'fragment' segments. Thus, an absolute URL has this generic structure:

    (scheme) : (//network location) /(path) ;(parameters) ?(query) #(fragment)

  The schemes can only contain letters, digits, '+', '.' and '-'. Hostname is the portion after the '//' and up to the first '/' (if any; else, up to the end) when ':' is followed by a '//' (e.g., 'abc.com' in 'ftp://abc.com/def'); otherwise, it consists of everything after the ':' (e.g., 'def@abc.com' in mailto:def@abc.com').

  `Relative` URLs do not have explicit schemes and network locations; such values are inherited from a `base` URL.


-- 5.6  Brief on htmLawed code -------------------------------------o


  Much of the code's logic and reasoning can be understood from the documentation above.

  The *output* of htmLawed is a text string containing the processed input. There is no custom error tracking.

  *Function arguments* for htmLawed are:

  *  '$in' - 1st argument; a text string; the *input text* to be processed. Any extraneous slashes added by PHP when `magic quotes` are enabled should be removed beforehand using PHP's 'stripslashes()' function.

  *  '$config' - 2nd argument; an associative array; optional (named '$C' in htmLawed code). The array has keys with names like 'balance' and 'keep_bad', and the values, which can be boolean, string, or array, depending on the key, are read to accordingly set the *configurable parameters* (indicated by the keys). All configurable parameters receive some default value if the value to be used is not specified by the user through '$config'. `Finalized` '$config' is thus a filtered and possibly larger array.

  *  '$spec' - 3rd argument; a text string; optional. The string has rules, written in an htmLawed-designated format, *specifying* element-specific attribute and attribute value restrictions. Function 'hl_spec()' is used to convert the string to an associative-array for internal use. `Finalized` '$spec' is thus an array.

  `Finalized` '$config' and '$spec' are made *global variables* while htmLawed is at work. Values of any pre-existing global variables with same names are noted, and their values are restored after htmLawed finishes processing the input (to capture the `finalized` values, the 'show_settings' parameter of '$config' should be used). Depending on '$config', another global variable 'hl_Ids', to track 'id' attribute values for uniqueness, may be set. Unlike the other two variables, this one is not reset (or unset) post-processing.

  Except for the main function 'htmLawed()' and the functions 'kses()' and 'kses_hook()', htmLawed's functions are *name-spaced* using the 'hl_' prefix. The *functions* and their roles are:

  *  'hl_attrval' - checking attribute values against $spec
  *  'hl_bal' - tag balancing
  *  'hl_cmtcd' - handling CDATA sections and HTML comments
  *  'hl_ent' - entity handling
  *  'hl_prot' - checking a URL scheme/protocol
  *  'hl_regex' - checking syntax of a regular expression
  *  'hl_spec' - converting user-supplied $spec value to one used by htmLawed internally
  *  'hl_tag' - handling tags
  *  'hl_tag2' - transforming tags
  *  'hl_tidy' - compact/beautify HTML 
  *  'hl_version' - reporting htmLawed version
  *  'htmLawed' - main function
  *  'kses' - main function of 'kses'
  *  'kses_hook' - hook function of 'kses'

  The last two are for compatibility with pre-existing code using the 'kses' script. htmLawed's 'kses()' basically passes on the filtering task to 'htmLawed()' function after deciphering '$config' and '$spec' from the argument values supplied to it. 'kses_hook()' is an empty function and is meant for being filled with custom code if the 'kses' script users were using one.

  'htmLawed()' finalizes '$spec' (with the help of 'hl_spec()') and '$config', and globalizes them. Finalization of '$config' involves setting default values if an inappropriate or invalid one is supplied. This includes calling 'hl_regex()' to check well-formedness of regular expression patterns if such expressions are user-supplied through '$config'. 'htmLawed()' then removes invalid characters like nulls and 'x01' and appropriately handles entities using 'hl_ent()'. HTML comments and CDATA sections are identified and treated as per '$config' with the help of 'hl_cmtcd()'. When retained, the '<' and '>' characters identifying them, and the '<', '>' and '&' characters inside them, are replaced with control characters (code-points '1' to '5') till any tag balancing is completed.

  After this `initial processing` 'htmLawed()' identifies tags using regex and processes them with the help of 'hl_tag()' --  a large function that analyzes tag content, filtering it as per HTML standards, '$config' and '$spec'. Among other things, 'hl_tag()' transforms deprecated elements using 'hl_tag2()', removes attributes from closing tags, checks attribute values as per '$spec' rules using 'hl_attrval()', and checks URL protocols using 'hl_prot()'. 'htmLawed()' performs tag balancing and nesting checks with a call to 'hl_bal()', and optionally compacts/beautifies the output with proper white-spacing with a call to 'hl_tidy()'. The latter temporarily replaces white-space, and '<', '>' and '&' characters inside 'pre', 'script' and 'textarea' elements, and HTML comments and CDATA sections with control characters (code-points '1' to '5', and '7').

  htmLawed permits the use of custom code or *hook functions* at two stages. The first, called inside 'htmLawed()', allows the input text as well as the finalized $config and $spec values to be altered right after the initial processing (see section:- #3.7). The second is called by 'hl_tag()' once the tag content is finalized (see section:- #3.4.9).

  Being dictated by the external and stable HTML standard, htmLawed's objective is very clear-cut and less concerned with tweakability. The code is only minimally annotated with comments -- it is not meant to instruct; PHP developers familiar with the HTML specs will see the logic, and others can always refer to the htmLawed documentation. The compact structuring of the statements is meant to aid in quickly grasping the logic, at least when viewed with code syntax highlighted.

___________________________________________________________________oo


@@description: htmLawed PHP software is a free, open-source, customizable HTML input purifier and filter
@@encoding: utf-8
@@keywords: htmLawed, HTM, HTML, HTML Tidy, converter, filter, formatter, purifier, sanitizer, XSS, input, PHP, software, code, script, security, cross-site scripting, hack, sanitize, remove, standards, tags, attributes, elements
@@language: en
@@title: htmLawed documentation