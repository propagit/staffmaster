<?php
/**
*	@desc A template for documentation
*	@name document_home_template
*
*/


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CodeIgniter Project Documentation Template</title>

<style type='text/css' media='all'>@import url("/_user_guide_src_ci/userguide.css");</style>
<link rel='stylesheet' type='text/css' media='all' href="/_user_guide_src_ci/userguide.css" />

<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />
<meta name='robots' content='all' />

</head>
<body>

<!-- START NAVIGATION -->
<div id="nav"><div id="nav_inner"></div></div>
<div id="nav2"><a name="top">&nbsp;</a></div>
<div id="masthead">
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
<td><h1>Project Title</h1></td>
<td id="breadcrumb_right"><a href="#">Right Breadcrumb</a></td>
</tr>
</table>
</div>
<!-- END NAVIGATION -->


<!-- START BREADCRUMB -->
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
<td id="breadcrumb">
<a href="http://example.com/">Project Home</a> &nbsp;&#8250;&nbsp;
<a href="#">User Guide Home</a> &nbsp;&#8250;&nbsp;
Foo Class
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="example.com/user_guide/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />


<!-- START CONTENT -->
<div id="content">


<h1>Foo Class</h1>

<p>Brief description of Foo Class.  If it extends a native CodeIgniter class, please link to the class in the CodeIgniter documents here.</p>

<p class="important"><strong>Important:</strong>&nbsp; This is an important note with <kbd>EMPHASIS</kbd>.</p>

<p>Features:</p>

<ul>
	<li>Foo</li>
	<li>Bar</li>
</ul>

<h2>Usage Heading</h2>

<p>Within a text string, <var>highlight variables</var> using <var>&lt;var&gt;&lt;/var&gt;</var> tags, and <dfn>highlight code</dfn> using the <dfn>&lt;dfn&gt;&lt;/dfn&gt;</dfn> tags.</p>

<h3>Sub-heading</h3>

<p>Put code examples within <dfn>&lt;code&gt;&lt;/code&gt;</dfn> tags:</p>

<code>
	$this->load->library('foo');<br />
	<br />
	$this->foo->bar('bat');
</code>


<h2>Table Preferences</h2>

<p>Use tables where appropriate for long lists of preferences.</p>


<table cellpadding="0" cellspacing="1" border="0" style="width:100%" class="tableborder">
<tr>
	<th>Preference</th>
	<th>Default&nbsp;Value</th>
	<th>Options</th>
	<th>Description</th>
</tr>
<tr>
	<td class="td"><strong>foo</strong></td>
	<td class="td">Foo</td>
	<td class="td">None</td>
	<td class="td">Description of foo.</td>
</tr>
<tr>
	<td class="td"><strong>bar</strong></td>
	<td class="td">Bar</td>
	<td class="td">bat, bag, or bak</td>
	<td class="td">Description of bar.</td>
</tr>
</table>

<h2>Foo Function Reference</h2>

<h3>$this->foo->bar()</h3>
<p>Description</p>
<code>$this->foo->bar('<var>baz</var>')</code>

</div>
<!-- END CONTENT -->


<div id="footer">
<p>
Previous Topic:&nbsp;&nbsp;<a href="#">Previous Class</a>
&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
<a href="#top">Top of Page</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
<a href="#">User Guide Home</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
Next Topic:&nbsp;&nbsp;<a href="#">Next Class</a>
</p>
<p><a href="http://codeigniter.com">CodeIgniter</a> &nbsp;&middot;&nbsp; Copyright &#169; 2006 - 2012 &nbsp;&middot;&nbsp; <a href="http://ellislab.com/">EllisLab, Inc.</a></p>
</div>

</body>
</html>