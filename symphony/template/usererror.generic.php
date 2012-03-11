<?php

	include_once(TOOLKIT . '/class.htmlpage.php');

	$Page = new HTMLPage();

	$Page->Html->setElementStyle('html');

	$Page->Html->setDTD('<!DOCTYPE html>');
	$Page->Html->setAttribute('xml:lang', 'en');
	$Page->addElementToHead(new XMLElement('meta', NULL, array('http-equiv' => 'Content-Type', 'content' => 'text/html; charset=UTF-8')), 0);
	$Page->addStylesheetToHead(SYMPHONY_URL . '/assets/css/symphony.basic.css', 'screen', 30);
	$Page->addStylesheetToHead(SYMPHONY_URL . '/assets/css/symphony.frames.css', 'screen', 31);

	$Page->addHeaderToPage('Status', '500 Internal Server Error', 500);
	$Page->addHeaderToPage('Content-Type', 'text/html; charset=UTF-8');
	$Page->addHeaderToPage('Symphony-Error-Type', 'generic');
	if(isset($e->getAdditional()->header)) $Page->addHeaderToPage($e->getAdditional()->header);

	$Page->setTitle(__('%1$s &ndash; %2$s', array(__('Symphony'), $e->getHeading())));
	$Page->Body->setAttribute('id', 'error');

	$div = new XMLElement('div', NULL, array('class' => 'frame'));
	$div->appendChild(new XMLElement('h1', $e->getHeading()));
	$div->appendChild(
		($e->getMessageObject() instanceof XMLElement ? $e->getMessageObject() : new XMLElement('p', trim($e->getMessage())))
	);
	$Page->Body->appendChild($div);

	$output = $Page->generate();
	header(sprintf('Content-Length: %d', strlen($output)));
	echo $output;

	exit;

