<?php 
require_once './model/Tags.php';
require_once './model/TagsDAO.php';

    $tags = new Tags(true, 0,'asta');
    var_dump($tags);
    $tagsDAO = new TagsDAO();
    var_dump($tagsDAO->insert($tags));