<?php
require __DIR__.'/../includes/bootstrap.php';

$type=(string)get('type','gadgets');
if(!in_array($type,['gadgets','jersey','fashion'],true)) $type='gadgets';
$cat=(string)get('cat','');

$themes=[
 'gadgets'=>[
   'eyebrow'=>'NEW ARRIVAL','title'=>"SMART TECH\nFOR SMART LIFE",
   'desc'=>"Latest gadgets at\nBest Prices",'cta'=>'EXPLORE GADGETS',
   'fallback'=>'https://placehold.co/1600x760/071513/ffffff?text=SMART+TECH+FOR+SMART+LIFE',
   'accent'=>'#20c9a4'
 ],
 'jersey'=>[
   'eyebrow'=>'NEW COLLECTION','title'=>"YOUR TEAM.\nYOUR JERSEY.",
   'desc'=>"Club, National & Custom\nName + Number Printing",'cta'=>'SHOP JERSEYS',
   'fallback'=>'https://placehold.co/1600x760/071513/ffffff?text=YOUR+TEAM+YOUR+JERSEY',
   'accent'=>'#588580'
 ],
 'fashion'=>[
   'eyebrow'=>'NEW COLLECTION','title'=>"STAY STYLISH\nEVERYDAY",
   'desc'=>"Premium Quality Fashion\nFor You",'cta'=>'SHOP FASHION',
   'fallback'=>'https://placehold.co/1600x760/efe4c8/151515?text=STAY+STYLISH+EVERYDAY',
   'accent'=>'#d2a94c'
 ],
];

$pdo=db();
$cst=$pdo->prepare("SELECT id,name,slug,image,type FROM categories WHERE type=? AND status=1 ORDER BY sort_order,name LIMIT 12");
$cst->execute([$type]);
$categories=[];
$iconMap=[
 'smartwatch'=>'solar:watch-square-linear','earbuds'=>'solar:headphones-round-linear',
 'bluetooth speakers'=>'solar:speaker-linear','speakers'=>'solar:speaker-linear',
 'chargers'=>'solar:plug-circle-linear','cables'=>'solar:usb-circle-linear',
 'power banks'=>'solar:battery-charge-linear','accessories'=>'solar:scissors-square-linear',
 'club jerseys'=>'solar:shirt-linear','national teams'=>'solar:flag-linear',
 'football'=>'solar:football-linear','cricket'=>'solar:ball-linear','retro jerseys'=>'solar:rewind-linear',
 'kids jersey'=>'solar:user-id-linear','custom jersey'=>'solar:pen-new-square-linear',
 't-shirts'=>'solar:t-shirt-linear','shirts'=>'solar:shirt-linear','pants'=>'solar:closet-linear',
 'jackets'=>'solar:wind-linear','shoes'=>'solar:running-2-linear','hoodies'=>'solar:t-shirt-linear',
];
while($c=$cst->fetch()){
    $key=strtolower($c['name']);
    $c['icon']=$iconMap[$key] ?? 'solar:box-linear';
    $categories[]=$c;
}

$sql="SELECT p.*,c.name category_name,c.slug category_slug,
      (SELECT image FROM product_images WHERE product_id=p.id ORDER BY sort_order,id LIMIT 1) AS image
      FROM products p JOIN categories c ON c.id=p.category_id
      WHERE p.status=1 AND c.type=?";
$params=[$type];
if($cat!==''){
    $sql.=" AND c.slug=?";
    $params[]=$cat;
}
$limit=max(1,min(24,(int)get("limit",6)));$offset=max(0,(int)get("offset",0));$sql.=" ORDER BY p.featured DESC,p.is_best_seller DESC,p.created_at DESC LIMIT ".$limit." OFFSET ".$offset;
$st=$pdo->prepare($sql);$st->execute($params);
$products=[];
while($p=$st->fetch()){
    $p['image']=image_or_placeholder($p['image'],$p['name']);
    $p['price']=(float)$p['price'];
    $p['compare_price']=$p['compare_price']!==null?(float)$p['compare_price']:null;
    $p['rating']=(float)$p['rating'];
    $products[]=$p;
}
$cntSql="SELECT COUNT(*) FROM products p JOIN categories c ON c.id=p.category_id WHERE p.status=1 AND c.type=?";$cntParams=[$type];if($cat!==''){ $cntSql.=" AND c.slug=?";$cntParams[]=$cat; }$cnt=$pdo->prepare($cntSql);$cnt->execute($cntParams);$totalProducts=(int)$cnt->fetchColumn();$hasMore=($offset+$limit)<$totalProducts;

$heroWidget=null;
$wst=$pdo->prepare("SELECT * FROM widgets WHERE status=1 AND placement='home' AND widget_type='banner' AND (niche=? OR niche='all' OR niche IS NULL) ORDER BY id LIMIT 1");
$wst->execute([$type]);
if($row=$wst->fetch()){
    $cfg=json_decode($row['config']??'{}',true)?:[];
    $heroWidget=[
      'title'=>$cfg['title']??'','text'=>$cfg['text']??'','cta_label'=>$cfg['cta_label']??'',
      'cta_url'=>$cfg['cta_url']??('/'.$type),'image'=>$cfg['image']??'',
      'icon'=>$cfg['icon']??'solar:box-linear'
    ];
}
if(!$heroWidget){
    $heroWidget=[
      'title'=>$themes[$type]['title'],'text'=>$themes[$type]['desc'],
      'cta_label'=>$themes[$type]['cta'],'cta_url'=>'/'.$type,
      'image'=>$themes[$type]['fallback'],'icon'=>'solar:stars-minimalistic-linear'
    ];
}

json_response([
 'ok'=>true,'type'=>$type,'cat'=>$cat,
 'theme'=>$themes[$type],
 'hero'=>$heroWidget,
 'categories'=>$categories,
 'products'=>$products,'offset'=>$offset,'limit'=>$limit,'has_more'=>$hasMore,'total'=>$totalProducts,'offset'=>$offset,'limit'=>$limit,'has_more'=>$hasMore,'total'=>$totalProducts,
]);
