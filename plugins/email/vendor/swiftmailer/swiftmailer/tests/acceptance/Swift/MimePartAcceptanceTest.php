<?php

require_once 'swift_required.php';
require_once __DIR__.'/Mime/MimePartAcceptanceTest.php';

class Swift_MimePartAcceptanceTest extends Swift_Mime_MimePartAcceptanceTest
{
    protected function createMimePart()
    {
        Swift_DependencyContainer::getInstance()
            ->register('properties.charset')->asValue(null);

        return new Swift_MimePart();
    }
}
