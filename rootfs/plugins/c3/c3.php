<?php
/**
 * Plugin Name: C3
 * Description: C3 hooks
 * Author: C3 team
 * Author URI: https://github.com/c3systems
 * Version: 0.1
 * Plugin URI: https://github.com/c3systems
 */
function post_published_notification( $ID, $post ) {
    $author = $post->post_author;
    $name = get_the_author_meta( 'display_name', $author );
    $email = get_the_author_meta( 'user_email', $author );
    $title = $post->post_title;
    $content = $post->post_content;
    $permalink = get_permalink( $ID );
    $edit = get_edit_post_link( $ID, '' );

    //$imageHash = getenv("IMAGE_ID");
    $imageHash = trim(file_get_contents("/image_id"));
    $content = preg_replace('/\s+/', ' ', trim($content));
    $data = <<<DATA
/usr/local/bin/c3-go sign --priv=/var/www/.c3/priv.pem --image="$imageHash" --payload='["createPost", "$title", "$content"]'
DATA;

    $tx = addslashes(trim(shell_exec($data)));
    $payload = addslashes("{\"jsonrpc\":\"2.0\",\"id\":\"1\",\"method\":\"c3_invokeMethod\",\"params\":[\"$tx\"]}");
    $cmd = <<<CMD
/usr/local/bin/grpcurl -v -plaintext -d "$payload" 123.123.123.123:5005 protos.C3Service/Send
CMD;
    // shell_exec('echo "'.$cmd.'" | nc 123.123.123.123 1111'); // debug

    $output = shell_exec(trim($cmd));
}

add_action( 'publish_post', 'post_published_notification', 10, 2 );
