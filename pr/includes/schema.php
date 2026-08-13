<?php
declare(strict_types=1);


function ensure_extra_schema(): void {
    $pdo=db();
    $pdo->exec("CREATE TABLE IF NOT EXISTS content_posts (
        id INTEGER PRIMARY KEY AUTOINCREMENT, post_type TEXT NOT NULL, title TEXT NOT NULL,
        slug TEXT NOT NULL, excerpt TEXT, content TEXT, status TEXT DEFAULT 'draft', visibility TEXT DEFAULT 'public',
        featured INTEGER DEFAULT 0, author_id INTEGER, category_id INTEGER, cover_image TEXT,
        seo_title TEXT, seo_description TEXT, seo_keywords TEXT, canonical_url TEXT, schema_type TEXT DEFAULT 'Article',
        og_image TEXT, published_at TEXT, created_at TEXT DEFAULT CURRENT_TIMESTAMP, updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
        UNIQUE(post_type,slug), FOREIGN KEY(author_id) REFERENCES users(id) ON DELETE SET NULL,
        FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE SET NULL
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS terms (
        id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, slug TEXT UNIQUE NOT NULL,
        taxonomy TEXT NOT NULL, post_type TEXT NOT NULL, description TEXT, parent_id INTEGER, status INTEGER DEFAULT 1,
        created_at TEXT DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(parent_id) REFERENCES terms(id) ON DELETE SET NULL
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS post_terms (post_id INTEGER NOT NULL, term_id INTEGER NOT NULL, PRIMARY KEY(post_id,term_id), FOREIGN KEY(post_id) REFERENCES content_posts(id) ON DELETE CASCADE, FOREIGN KEY(term_id) REFERENCES terms(id) ON DELETE CASCADE)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS media (id INTEGER PRIMARY KEY AUTOINCREMENT, filename TEXT NOT NULL, path TEXT NOT NULL, mime TEXT, size INTEGER DEFAULT 0, alt_text TEXT, title TEXT, uploaded_by INTEGER, created_at TEXT DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(uploaded_by) REFERENCES users(id) ON DELETE SET NULL)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS menus (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, location TEXT NOT NULL, status INTEGER DEFAULT 1, created_at TEXT DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS menu_items (id INTEGER PRIMARY KEY AUTOINCREMENT, menu_id INTEGER NOT NULL, parent_id INTEGER, label TEXT NOT NULL, url TEXT NOT NULL, target TEXT DEFAULT '_self', sort_order INTEGER DEFAULT 0, visibility TEXT DEFAULT 'all', icon TEXT, FOREIGN KEY(menu_id) REFERENCES menus(id) ON DELETE CASCADE, FOREIGN KEY(parent_id) REFERENCES menu_items(id) ON DELETE SET NULL)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS widgets (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, widget_type TEXT NOT NULL, placement TEXT NOT NULL, niche TEXT, config TEXT, status INTEGER DEFAULT 1, created_at TEXT DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS shortcodes (id INTEGER PRIMARY KEY AUTOINCREMENT, label TEXT NOT NULL, code TEXT UNIQUE NOT NULL, content_type TEXT DEFAULT 'text', content TEXT, status INTEGER DEFAULT 1, created_at TEXT DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS comments (id INTEGER PRIMARY KEY AUTOINCREMENT, post_id INTEGER, user_id INTEGER, author_name TEXT, author_email TEXT, comment TEXT NOT NULL, status TEXT DEFAULT 'pending', ip TEXT, created_at TEXT DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(post_id) REFERENCES content_posts(id) ON DELETE CASCADE, FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS contact_requests (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT, phone TEXT, subject TEXT, message TEXT NOT NULL, status TEXT DEFAULT 'new', notes TEXT, created_at TEXT DEFAULT CURRENT_TIMESTAMP, handled_at TEXT)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS import_runs (id INTEGER PRIMARY KEY AUTOINCREMENT, source TEXT, source_type TEXT, imported INTEGER DEFAULT 0, skipped INTEGER DEFAULT 0, errors INTEGER DEFAULT 0, logs TEXT, created_at TEXT DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS role_permissions (role TEXT PRIMARY KEY, permissions TEXT NOT NULL)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS compares (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, product_id INTEGER NOT NULL, session_key TEXT, created_at TEXT DEFAULT CURRENT_TIMESTAMP, UNIQUE(user_id,product_id), FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE, FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE)");
    $cols=$pdo->query('PRAGMA table_info(users)')->fetchAll(PDO::FETCH_COLUMN,1);
    foreach([['permissions','TEXT'],['avatar','TEXT'],['address','TEXT'],['city','TEXT'],['area','TEXT'],['postal_code','TEXT'],['country','TEXT'],['company','TEXT'],['bio','TEXT']] as $c){ if(!in_array($c[0],$cols,true)) $pdo->exec('ALTER TABLE users ADD COLUMN '.$c[0].' '.$c[1]); }
    foreach([['permissions','TEXT'],['avatar','TEXT'],['address','TEXT'],['city','TEXT'],['area','TEXT'],['postal_code','TEXT'],['country','TEXT'],['company','TEXT'],['bio','TEXT']] as $c){ if(!in_array($c[0],$cols,true)) $pdo->exec('ALTER TABLE users ADD COLUMN '.$c[0].' '.$c[1]); }
    if(!in_array('permissions',$cols,true)) $pdo->exec('ALTER TABLE users ADD COLUMN permissions TEXT');
    $pdo->exec("INSERT OR IGNORE INTO role_permissions(role,permissions) VALUES ('admin','{}'),('manager','{\"products\":1,\"orders\":1,\"inventory\":1,\"content\":1,\"reviews\":1,\"contacts\":1}'),('editor','{\"content\":1,\"media\":1,\"reviews\":1,\"contacts\":1}')");
    $st=$pdo->prepare('INSERT OR IGNORE INTO settings(key,value) VALUES(?,?)');
    foreach([
      ['site_tagline','All in One Store'],['site_description','Gadgets, jerseys, fashion and more.'],['site_keywords','gadgets, jersey, fashion, Bangladesh, PAROKO'],['currency','BDT'],['currency_symbol','৳'],['logo_url',''],['favicon_url',''],
      ['social_facebook',''],['social_instagram',''],['social_youtube',''],['social_tiktok',''],['social_whatsapp',''],['payment_enabled','cod,bkash,nagad,rocket,sslcommerz'],
      ['payment_bkash_key',''],['payment_bkash_secret',''],['payment_nagad_key',''],['payment_nagad_secret',''],['payment_ssl_key',''],['payment_ssl_secret',''],['meta_pixel_id',''],['meta_capi_token',''],['google_analytics',''],['site_schema_json',''],['header_code',''],['footer_code',''],['seo_robots','index,follow'],['speed_lazyload','1'],['speed_minify','1']
    ] as $d)$st->execute($d);
    if((int)$pdo->query('SELECT COUNT(*) FROM widgets')->fetchColumn()===0){
      $defaults=[
        ['Hero CTA','cta','home','all',['title'=>'Latest Tech. Ultimate Style.','text'=>'Explore our newest products with fast delivery.','cta_label'=>'Shop Now','cta_url'=>'/gadgets','icon'=>'solar:bolt-linear','image'=>'']],
        ['Why Shop PAROKO','category_posts','home','all',['title'=>'Why Shop With Us?','text'=>'Fast delivery, secure checkout and quality products.','cta_label'=>'Explore Store','cta_url'=>'/','icon'=>'solar:shield-check-linear','image'=>'']],
        ['Jersey Promo','banner','home','jersey',['title'=>'Customize Your Jersey','text'=>'Add your name and number to your favourite jersey.','cta_label'=>'Customize Now','cta_url'=>'/jersey','icon'=>'solar:shirt-linear','image'=>'']],
      ];
      $stW=$pdo->prepare('INSERT INTO widgets(name,widget_type,placement,niche,config,status) VALUES(?,?,?,?,?,1)');
      foreach($defaults as $w)$stW->execute([$w[0],$w[1],$w[2],$w[3],json_encode($w[4],JSON_UNESCAPED_UNICODE)]);
    }
    if(setting('typography_preset','')===''){
      $stT=$pdo->prepare('INSERT OR IGNORE INTO settings(key,value) VALUES(?,?)');
      foreach([
        ['typography_font','Inter'],['typography_base','16'],['typography_scale','1'],['typography_heading_weight','800'],['ui_radius','18'],['ui_preset','gradient600']
      ] as $d)$stT->execute($d);
    }
    if((int)$pdo->query('SELECT COUNT(*) FROM widgets')->fetchColumn()===0){
      $defaults=[
        ['Hero CTA','cta','home','all',['title'=>'Latest Tech. Ultimate Style.','text'=>'Explore our newest products with fast delivery.','cta_label'=>'Shop Now','cta_url'=>'/gadgets','icon'=>'solar:bolt-linear','image'=>'']],
        ['Why Shop PAROKO','category_posts','home','all',['title'=>'Why Shop With Us?','text'=>'Fast delivery, secure checkout and quality products.','cta_label'=>'Explore Store','cta_url'=>'/','icon'=>'solar:shield-check-linear','image'=>'']],
        ['Jersey Promo','banner','home','jersey',['title'=>'Customize Your Jersey','text'=>'Add your name and number to your favourite jersey.','cta_label'=>'Customize Now','cta_url'=>'/jersey','icon'=>'solar:shirt-linear','image'=>'']],
      ];
      $stW=$pdo->prepare('INSERT INTO widgets(name,widget_type,placement,niche,config,status) VALUES(?,?,?,?,?,1)');
      foreach($defaults as $w)$stW->execute([$w[0],$w[1],$w[2],$w[3],json_encode($w[4],JSON_UNESCAPED_UNICODE)]);
    }
    if(setting('typography_preset','')===''){
      $stT=$pdo->prepare('INSERT OR IGNORE INTO settings(key,value) VALUES(?,?)');
      foreach([
        ['typography_font','Inter'],['typography_base','16'],['typography_scale','1'],['typography_heading_weight','800'],['ui_radius','18'],['ui_preset','gradient600']
      ] as $d)$stT->execute($d);
    }
    if((int)$pdo->query('SELECT COUNT(*) FROM terms')->fetchColumn()===0){
      foreach(['gadgets','jersey','fashion','articles','docs','pages'] as $type){foreach(['Featured','New','Sale','Trending'] as $tag){$x=$pdo->prepare('INSERT OR IGNORE INTO terms(name,slug,taxonomy,post_type) VALUES(?,?,?,?)');$x->execute([$tag,slugify($tag.'-'.$type),'tag',$type]);}}
    }
}

function ensure_schema(): void {
    static $done=false; if($done)return; $done=true;
    $pdo=db();
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT UNIQUE NOT NULL, phone TEXT,
        password TEXT NOT NULL, role TEXT NOT NULL DEFAULT 'customer', status INTEGER NOT NULL DEFAULT 1,
        created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT, parent_id INTEGER, name TEXT NOT NULL, slug TEXT UNIQUE NOT NULL,
        type TEXT NOT NULL, description TEXT, image TEXT, banner TEXT, sort_order INTEGER DEFAULT 0, status INTEGER DEFAULT 1,
        FOREIGN KEY(parent_id) REFERENCES categories(id) ON DELETE SET NULL
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT, category_id INTEGER NOT NULL, brand TEXT, name TEXT NOT NULL,
        slug TEXT UNIQUE NOT NULL, sku TEXT UNIQUE NOT NULL, description TEXT, short_description TEXT,
        price REAL NOT NULL DEFAULT 0, compare_price REAL, cost_price REAL, warranty TEXT, status INTEGER DEFAULT 1,
        featured INTEGER DEFAULT 0, is_new INTEGER DEFAULT 0, is_best_seller INTEGER DEFAULT 0,
        rating REAL DEFAULT 0, review_count INTEGER DEFAULT 0, created_at TEXT DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE RESTRICT
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS variants (
        id INTEGER PRIMARY KEY AUTOINCREMENT, product_id INTEGER NOT NULL, sku TEXT UNIQUE NOT NULL,
        color TEXT, size TEXT, material TEXT, price REAL, compare_price REAL, image TEXT, stock INTEGER DEFAULT 0,
        low_stock_threshold INTEGER DEFAULT 5, status INTEGER DEFAULT 1,
        FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS product_images (
        id INTEGER PRIMARY KEY AUTOINCREMENT, product_id INTEGER NOT NULL, image TEXT NOT NULL, sort_order INTEGER DEFAULT 0,
        FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS product_specs (
        id INTEGER PRIMARY KEY AUTOINCREMENT, product_id INTEGER NOT NULL, spec_key TEXT NOT NULL, spec_value TEXT NOT NULL,
        sort_order INTEGER DEFAULT 0, FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT, order_number TEXT UNIQUE NOT NULL, customer_id INTEGER, customer_name TEXT NOT NULL,
        customer_phone TEXT NOT NULL, customer_email TEXT, customer_address TEXT NOT NULL, city TEXT NOT NULL,
        area TEXT, postal_code TEXT, subtotal REAL DEFAULT 0, discount REAL DEFAULT 0, shipping_cost REAL DEFAULT 0,
        total REAL DEFAULT 0, payment_method TEXT DEFAULT 'cod', payment_status TEXT DEFAULT 'pending',
        order_status TEXT DEFAULT 'pending', courier TEXT, tracking_number TEXT, notes TEXT,
        created_at TEXT DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(customer_id) REFERENCES users(id) ON DELETE SET NULL
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT, order_id INTEGER NOT NULL, product_id INTEGER, variant_id INTEGER,
        product_name TEXT NOT NULL, sku TEXT, quantity INTEGER NOT NULL, unit_price REAL NOT NULL, total REAL NOT NULL,
        size TEXT, color TEXT, custom_name TEXT, custom_number TEXT, printing_charge REAL DEFAULT 0,
        FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE, FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE SET NULL,
        FOREIGN KEY(variant_id) REFERENCES variants(id) ON DELETE SET NULL
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS wishlists (
        id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER NOT NULL, product_id INTEGER NOT NULL,
        UNIQUE(user_id,product_id), FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS coupons (
        id INTEGER PRIMARY KEY AUTOINCREMENT, code TEXT UNIQUE NOT NULL, type TEXT NOT NULL, value REAL NOT NULL,
        min_amount REAL DEFAULT 0, max_discount REAL, usage_limit INTEGER, used_count INTEGER DEFAULT 0,
        start_date TEXT, end_date TEXT, status INTEGER DEFAULT 1
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT, product_id INTEGER NOT NULL, user_id INTEGER, rating INTEGER NOT NULL,
        title TEXT, review TEXT, status INTEGER DEFAULT 1, created_at TEXT DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE, FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS inventory_logs (
        id INTEGER PRIMARY KEY AUTOINCREMENT, product_id INTEGER NOT NULL, variant_id INTEGER, type TEXT NOT NULL,
        quantity INTEGER NOT NULL, reference TEXT, notes TEXT, created_by INTEGER, created_at TEXT DEFAULT CURRENT_TIMESTAMP
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (key TEXT PRIMARY KEY, value TEXT)");
    seed_data();
    ensure_extra_schema();
}

function seed_data(): void {
    $pdo=db();
    $count=(int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    if($count===0){
        $st=$pdo->prepare('INSERT INTO users(name,email,phone,password,role) VALUES(?,?,?,?,?)');
        $st->execute(['PAROKO Admin', DEMO_ADMIN_EMAIL, '01712345678', password_hash(DEMO_ADMIN_PASSWORD,PASSWORD_DEFAULT), 'admin']);
    }
    $settings=[
        ['store_name','PAROKO'],['store_phone','01712-345678'],['whatsapp','8801712345678'],['shipping_inside','120'],
        ['shipping_outside','180'],['printing_charge','150'],['currency','BDT'],['announcement','Fast Delivery Across Bangladesh · Cash on Delivery available']
    ];
    $st=$pdo->prepare('INSERT OR IGNORE INTO settings(key,value) VALUES(?,?)'); foreach($settings as $r)$st->execute($r);

    $cats=[
      'gadgets'=>['Smartwatch','Earbuds','Bluetooth Speakers','Chargers','Cables','Phone Accessories','Power Banks','Mobile Accessories'],
      'jersey'=>['Club Jerseys','National Teams','Football','Cricket','Retro Jerseys','Kids Jersey','Custom Jersey'],
      'fashion'=>['T-Shirts','Pants','Jackets','Hoodies','Shoes','Casual Wear','Men Fashion','Women Fashion']
    ];
    // SQLite-friendly category insert without malformed placeholder variants.
    foreach($cats as $type=>$names){
      foreach($names as $i=>$name){
        $slug=slugify($name);
        $st=$pdo->prepare('INSERT OR IGNORE INTO categories(name,slug,type,sort_order) VALUES(?,?,?,?)');
        $st->execute([$name,$slug,$type,$i]);
      }
    }

    $pcount=(int)$pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
    if($pcount===0){
      $products=[
       ['gadgets','Smartwatch X9',1499,1799,'smartwatch-x9','GAD-X9','Premium AMOLED smartwatch with Bluetooth calling.'],
       ['gadgets','Anker Soundcore R50i Earbuds',2150,2660,'anker-soundcore-r50i','GAD-R50I','Deep bass wireless earbuds with long battery life.'],
       ['gadgets','Baseus 20W Fast Charger',990,1190,'baseus-20w-charger','GAD-B20','Compact 20W fast charger.'],
       ['gadgets','Ugreen USB-C Cable 1M',550,650,'ugreen-usbc-1m','GAD-U1M','Durable USB-C charging and data cable.'],
       ['jersey','Real Madrid Home Jersey 24/25',1550,1790,'real-madrid-home-2425','JER-RMA2425','Premium football jersey with optional name and number printing.'],
       ['jersey','Barcelona Home Jersey 24/25',1550,1790,'barcelona-home-2425','JER-FCB2425','Barcelona home jersey.'],
       ['jersey','Argentina Home Jersey 24/25',1650,1890,'argentina-home-2425','JER-ARG2425','Argentina home jersey.'],
       ['jersey','Manchester United Home Jersey',1550,1790,'manchester-utd-home','JER-MUFC','Manchester United home jersey.'],
       ['jersey','Brazil Home Jersey 24/25',1450,1690,'brazil-home-2425','JER-BRA2425','Brazil home jersey.'],
       ['jersey','Liverpool Home Jersey 24/25',1550,1790,'liverpool-home-2425','JER-LIV2425','Liverpool home jersey.'],
       ['fashion','Oversized Black T-Shirt',650,799,'oversized-black-tshirt','FAS-OBT','Premium cotton oversized fit.'],
       ['fashion','Cargo Pants',1190,1390,'cargo-pants','FAS-CP','Everyday cargo pants.'],
       ['fashion','Casual Jacket',1590,1890,'casual-jacket','FAS-CJ','Lightweight casual jacket.'],
       ['fashion','Everyday Sneakers',1890,2190,'everyday-sneakers','FAS-ES','Comfort everyday sneakers.']
      ];
      foreach($products as [$type,$name,$price,$compare,$slug,$sku,$desc]){
        $cat=$pdo->prepare('SELECT id FROM categories WHERE type=? ORDER BY sort_order LIMIT 1');$cat->execute([$type]);$categoryId=(int)$cat->fetchColumn();
        $st=$pdo->prepare('INSERT INTO products(category_id,brand,name,slug,sku,description,short_description,price,compare_price,warranty,status,featured,is_new,is_best_seller,rating,review_count) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $st->execute([$categoryId,'PAROKO',$name,$slug,$sku,$desc,$desc,$price,$compare,$type==='gadgets'?'7 Days':null,1,1,1,1,4.8,rand(20,120)]);
        $pid=(int)$pdo->lastInsertId();
        $image='https://placehold.co/900x900/f8fafc/111827?text='.rawurlencode($name);
        $pdo->prepare('INSERT INTO product_images(product_id,image,sort_order) VALUES(?,?,0)')->execute([$pid,$image]);
        $pdo->prepare('INSERT INTO variants(product_id,sku,color,size,price,compare_price,stock,low_stock_threshold) VALUES(?,?,?,?,?,?,?,5)')->execute([$pid,$sku.'-M','Black','M',$price,$compare,rand(4,30)]);
        $specs=$type==='gadgets'?[['Display','AMOLED'],['Bluetooth','5.3'],['Warranty','7 Days']]:($type==='jersey'?[['Material','Premium Polyester'],['Fit','Regular'],['Printing','Name + Number available']]:[['Material','100% Cotton'],['Fit','Regular/Oversized'],['Weight','220 GSM']]);
        $sp=$pdo->prepare('INSERT INTO product_specs(product_id,spec_key,spec_value,sort_order) VALUES(?,?,?,?)'); foreach($specs as $i=>$s){$sp->execute([$pid,$s[0],$s[1],$i]);}
      }
    }
    $cc=(int)$pdo->query('SELECT COUNT(*) FROM coupons')->fetchColumn();
    if($cc===0){$pdo->prepare('INSERT INTO coupons(code,type,value,min_amount,max_discount,usage_limit) VALUES(?,?,?,?,?,?)')->execute(['WELCOME10','percent',10,1000,500,100]);}
}

ensure_schema();

ensure_extra_schema();
