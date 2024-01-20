<?php
    if (isset($page_title) && $page_title != "") {
        $title = $page_title;
    }else{
        $title = get_option('website_title', "SmartStore - Social Media Marketing Store Script");
    }

    if (isset($page_meta_keywords) && $page_meta_keywords != "") {
        $meta_keywords = $page_meta_keywords;
    }else{
        $meta_keywords = get_option('website_keywords', "SmartStore, smm reseller panel, smmpanel, panelsmm, create smm store, business smm, socialmedia, instagram reseller panel, create smm store, resell smm services, smm store, start smm business, cheap smm business, buy instagram followers, instagram likes, facebook followers, facebook likes, twitter likes, youtube views, soundclound");
    }

    if (isset($page_meta_description) && $page_meta_description != "") {
        $meta_description = $page_meta_description;
    }else{
        $meta_description = get_option('website_desc', "SmartStore is the best option to get all social media services in website. Easy build Social Media Marketing Store with a unique design and business process automation");
    }
?>
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" >
    <meta name="description" content="<?php echo strip_tags($meta_description)?>">
    <meta name="keywords" content="<?php echo strip_tags($meta_keywords)?>">
    <title><?php echo strip_tags($title); ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_option('website_favicon', BASE."assets/images/favicon.png"); ?>">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <!-- Core -->
    <link href="<?php echo BASE; ?>assets/css/core.css" rel="stylesheet">
    <!-- toast -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/plugins/jquery-toast/css/jquery.toast.css">
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/boostrap/colors.css" id="theme-stylesheet">
    <!-- OwlCarousel -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/plugins/owlcarousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/plugins/owlcarousel/dist/assets/owl.theme.default.min.css">
    <link href="<?php echo BASE; ?>assets/css/util.css" rel="stylesheet">
    <link href="<?php echo BASE; ?>assets/css/user.css" rel="stylesheet">
    <link href="<?php echo BASE; ?>assets/css/footer.css" rel="stylesheet">
    
    <script src="<?php echo BASE; ?>assets/plugins/vendors/jquery-3.2.1.min.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/owlcarousel/dist/owl.carousel.min.js"></script>
    <script type="text/javascript">
      var token = '<?php echo strip_tags($this->security->get_csrf_hash()); ?>',
          PATH  = '<?php echo PATH; ?>',
          BASE  = '<?php echo BASE; ?>';
      var    deleteItem = '<?php echo lang("Are_you_sure_you_want_to_delete_this_item"); ?>';
      var    deleteItems = '<?php echo lang("Are_you_sure_you_want_to_delete_all_items"); ?>';
    </script>
    <?php
        if (segment('1') != 'admin') {
    ?>
        <?=htmlspecialchars_decode(get_option('embed_head_javascript', ''), ENT_QUOTES)?>
        <?php if(isset($pageType) && ($pageType == 'main' || $pageType == 'product')): ?>
        <script type='application/ld+json' class='yoast-schema-graph yoast-schema-graph--main'>
            {
   "@context": "https://schema.org",
   "@graph": [
      {
         "@type": "Organization",
         "@id": "<?php echo cn(); ?>#organization",
         "name": "Instahotstar",
         "url": "<?php echo cn(); ?>",
         "sameAs": [],
         "logo": {
            "@type": "ImageObject",
            "@id": "<?php echo cn(); ?>#logo",
            "inLanguage": "en-US",
            "url": "<?php echo get_option('website_logo', BASE."assets/images/logo.png"); ?>",
            "width": 512,
            "height": 512,
            "caption": "Instahotstar"
         },
         "image": {
            "@id": "<?php echo cn(); ?>#logo"
         }
      },
      {
         "@type": "WebSite",
         "@id": "<?php echo cn(); ?>#website",
         "url": "<?php echo cn(); ?>",
         "name": "Instahotstar",
         "inLanguage": "en-US",
         "description": "Buy Instagram Likes, Followers, and views",
         "publisher": {
            "@id": "<?php echo cn(); ?>#organization"
         },
         "potentialAction": {
            "@type": "SearchAction",
            "target": "<?php echo cn(); ?>?s={search_term_string}",
            "query-input": "required name=search_term_string"
         }
      },
      {
         "@type": "WebPage",
         "@id": "<?php echo (isset($pageUrl) && $pageUrl != '')?$pageUrl:cn(); ?>/#webpage",
         "url": "<?php echo (isset($pageUrl) && $pageUrl != '')?$pageUrl:cn(); ?>",
         "name": "<?php echo strip_tags($title); ?>",
         "isPartOf": {
            "@id": "<?php echo cn(); ?>#website"
         },
         "inLanguage": "en-US",
         "datePublished": "<?php echo (isset($poublishedAt) && $poublishedAt != '')?$poublishedAt:''; ?>",
         "dateModified": "<?php echo (isset($modifiedAt) && $modifiedAt != '')?$modifiedAt:''; ?>",
         "description": "<?php echo strip_tags($meta_description)?>"
      }
   ]
}</script>
<?php endif; ?>

<?php if(isset($pageType) && $pageType == 'product'): ?>
        <script type="application/ld+json">
{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "<?php echo strip_tags($title); ?>",
  "image": "<?php echo (isset($productImage) && $productImage != '')?$productImage:''; ?>",
  "description": "<?php echo strip_tags($title); ?>",
  "brand": "Instahotstar",
  "sku": "<?php echo (isset($sku) && $sku != '')?$sku:0; ?>",
  "mpn": "<?php echo (isset($sku) && $sku != '')?$sku:0; ?>",
  "offers": {
    "@type": "Offer",
    "url": "<?php echo (isset($pageUrl) && $pageUrl != '')?$pageUrl:cn(); ?>",
    "priceCurrency": "USD",
    "price": "<?php echo (isset($offerPrice))?number_format((float)$offerPrice, 2, '.', ''):''; ?>",
    "priceValidUntil": "<?php echo date('Y-m-d', strtotime('+1 years')) ?>",
    "availability": "https://schema.org/InStock",
    "itemCondition": "https://schema.org/NewCondition"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php echo (isset($product_rating) && $product_rating != '')?round($product_rating):0; ?>",
    "bestRating": "5",
    "worstRating": "5",
    "ratingCount": "<?php echo (isset($product_review_count) && $product_review_count != '')?$product_review_count:0; ?>"
  },"review": [
      <?php $count=1;foreach($reviews as $review): ?>
    {
      "@type": "Review",
      "author": "<?php echo (isset($review->name))?$review->name:''; ?>",
      "datePublished": "<?php echo (isset($review->created_at))?$review->created_at:''; ?>",
      "description": "<?php echo (isset($review->review))?str_replace('"','',$review->review):''; ?>",
      "name": "",
      "reviewRating": {
        "@type": "Rating",
        "bestRating": "5",
        "ratingValue": "<?php echo (isset($review->rating))?round($review->rating):0; ?>",
        "worstRating": "1"
      }
    }<?php if($product_review_count != $count){ echo ",";} ?>
    <?php $count++;endforeach; ?>
  ]
}
</script>
<?php endif; ?>
    <?php }//exit; ?>
  </head>
  <body>
    <div id="page-overlay" class="visible incoming">
      <div class="loader-wrapper-outer">
        <div class="loader-wrapper-inner">
          <div class="lds-double-ring">
            <div></div>
            <div></div>
            <div>
              <div></div>
            </div>
            <div>
              <div></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- load general header -->
    <?php echo Modules::run("blocks/user_header");?>

    <?php echo $template['body']; ?>
    
    <?php echo Modules::run("blocks/footer");?>

    <!-- Stripe JavaScript library -->
    <?php
        if (get_option('is_active_stripe') && segment('1') == 'checkout') {
    ?>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    
    <?php } ?>
    
    <script src="<?php echo BASE; ?>assets/plugins/vendors/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/vendors/jquery.sparkline.min.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/vendors/selectize.min.js"></script>
    <script src="<?php echo BASE; ?>assets/js/core.js"></script>
    <!-- general JS -->
    <script src="<?php echo BASE; ?>assets/js/process.js"></script>
    <script src="<?php echo BASE; ?>assets/js/general.js"></script>
    <script src="<?php echo BASE; ?>assets/js/jquery.payform.min.js" charset="utf-8"></script>
    
    <script>
      $(document).ready(function () {
        $('#select-payments').selectize({
            render: {
                option: function (data, escape) {
                    return '<div>' +
                        '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                        '<span class="title">' + escape(data.text) + '</span>' +
                        '</div>';
                },
                item: function (data, escape) {
                    return '<div>' +
                        '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                        escape(data.text) +
                        '</div>';
                }
            }
        });
      });
    </script>
    <?php
        if (segment('1') != 'admin') {
    ?>
        <?php echo htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES); ?>
    <?php } ?>
  </body>
</html>

