<?php

require_once 'vendor/autoload.php';

$tb = new TopicBuilder($_POST);
echo $tb->generateTopic();
