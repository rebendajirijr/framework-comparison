<?php //netteCache[01]000373a:2:{s:4:"time";s:21:"0.51464600 1398966611";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:59:"C:\xampp\htdocs\test\nette\app\templates\Book\default.latte";i:2;i:1398935418;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:22:"released on 2014-03-17";}}}?><?php

// source file: C:\xampp\htdocs\test\nette\app\templates\Book\default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'ragljl9drm')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb95e9453fe9_content')) { function _lb95e9453fe9_content($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><p><a href="<?php echo htmlSpecialChars($_control->link("Books:")) ?>">Back to list</a></p>
<hr>
<h1><?php echo Nette\Templating\Helpers::escapeHtml($book->name, ENT_NOQUOTES) ?></h1>
<p>Author: <?php echo Nette\Templating\Helpers::escapeHtml($book->author, ENT_NOQUOTES) ?></p>
<p>Published: <?php echo Nette\Templating\Helpers::escapeHtml($book->datePublished->format('Y-m-d'), ENT_NOQUOTES) ?></p>
<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 