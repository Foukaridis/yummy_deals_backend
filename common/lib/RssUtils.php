<?php
/**
 * Created by Fruity Solution Co.Ltd.
 * User: Only Love
 * Date: 10/17/13 - 7:53 AM
 * 
 * Please keep copyright headers of source code files when use it.
 * Thank you!
 */

class RssUtils extends JUtils{
    public static function createInstance(){
        return new RssUtils();
    }

    function getFeed($feed_url) {
        $content = file_get_contents($feed_url);
        $x = new SimpleXmlElement($content);
        $result = array();
        foreach($x->channel->item as $entry) {
            $result[] = array(
                'title' => $entry->title.'',
                'link' => $entry->link.'',
                'description' => $entry->description.'',
                'pubDate' => $entry->pubDate.'',
                'image' => isset($entry->image) ? $entry->image.'' : '',
            );
        }
        return $result;
    }
}