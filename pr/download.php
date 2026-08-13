<?php
require __DIR__.'/includes/bootstrap.php';
if(!user()){http_response_code(403);exit('Login required.');}
$token=trim((string)get('token',''));if($token===''){http_response_code(404);exit('Invalid download token.');}
$st=db()->prepare('SELECT dt.*,pf.filename,pf.stored_path,pf.mime,pf.size,pf.status file_status FROM download_tokens dt JOIN product_files pf ON pf.id=dt.file_id WHERE dt.token=? LIMIT 1');$st->execute([$token]);$row=$st->fetch();
if(!$row || (int)$row['file_status']!==1 || (int)$row['user_id']!==(int)user()['id']){http_response_code(403);exit('Unauthorized download.');}
if(strtotime((string)$row['expires_at'])<time()){http_response_code(410);exit('Download token expired. Please request a new download.');}
if(!empty($row['used_at'])){http_response_code(410);exit('Download token already used.');}
if(!user_has_purchased_product((int)user()['id'],(int)$row['product_id'])){http_response_code(403);exit('You have not purchased this product.');}
if(!is_file($row['stored_path'])){http_response_code(404);exit('Protected file not found.');}
// One-time token. New token can be requested from the order/account page.
db()->prepare('UPDATE download_tokens SET used_at=CURRENT_TIMESTAMP WHERE id=?')->execute([(int)$row['id']]);
db()->prepare('UPDATE product_files SET downloads=downloads+1 WHERE id=?')->execute([(int)$row['file_id']]);
$safeName=preg_replace('/[^A-Za-z0-9._-]+/','_',basename((string)$row['filename']))?:'download.zip';header('Content-Type: '.($row['mime']?:'application/zip'));header('Content-Length: '.filesize($row['stored_path']));header('Content-Disposition: attachment; filename="'.$safeName.'"');header('X-Content-Type-Options: nosniff');header('Cache-Control: private, no-store, no-cache, must-revalidate');
readfile($row['stored_path']);exit;
?>
