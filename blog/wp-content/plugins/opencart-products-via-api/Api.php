<?php
require_once 'sg/SendGrid_loader.php';


/**
 * BKY API wrapper.
 */
class BKY_Api
{

    //API Login Details
    static private $store_url = 'https://store-w0juk.mybigcommerce.com';
    static private $username = 'admin';
    static private $api_key = 'fbf32f1fc035ed385955ffdc9728f5e6';
    
    // Which action to do
    static private $action;
    
    static private $jsonResponse;

    static private $skuExplode = '--PLUS--';
    
    //standard product data as returned by BC
    static private $productsData;
    
    // FTP Login Details
    static private $ftp_server = 'server4200.bigcommerce.com';
    static private $ftp_user_name = 's353642';
    static private $ftp_user_pass = 'oddmanj2';
    
    static private $sendgrid;
    
    // SKU GEN ARRAYS
    static private $bottomSKUS;
    static private $topSKUS;
    static private $nfsSets = array();
    static private $setsWithOptions = array();
    static private $totalCountDisplayOnly;
    
    static private $sizeMap = array (
                            'XSL' => 'Extra Small',
                            'SML' => 'Small',
                            'MED' => 'Medium',
                            'LRG' => 'Large'
                            );
    
    static private $colorMap = array (
                            'BLK' => 'Black',
                            'WHT' => 'White',
                            'PPL' => 'Deep Purple',
                            'CRL' => 'Coral',
                            'PT1' => 'Print 1',
                            'YLW' => 'Yellow',
                            'TQS' => 'Turquoise',
                            'PT2' => 'Print 2',
                            'RED' => 'Red',
                            'NVY' => 'Navy',
                            'OWT' => 'Off-White'


                            );
    

        
    /**
    * Init the Bikyni API controller
    *
    * Requires a settings array to be passed in with the following keys:
    *
    *
    */
    public static function init()
    {
        if ( self::auth() ) {
            
            BigCommerce_Api::configure(array(
                'store_url' => self::$store_url,
                'username'  => self::$username,
                'api_key'   => self::$api_key
            ));
            
            self::getAction();
            switch (self::$action) {
                case 'looks':
                    
                        
                    $conf = array(
                        'fileName' => 'lookFilters.json',
                        'saveToDir' => 'looks'
                    );
                    self::getDataForLooks();
                    self::saveAndSendToBC($conf);
                break;
            
                case 'products':
                    
                    
                    
                    self::$productsData = self::getProducts();
                    self::convertProductsToJsonBySku();
                    echo "END do products";
                break;
            
                case 'SKUGen':
                    
                    self::SKUGen();
                    self::createSets();
                    self::createOptions();
                    self::createIndividualProductsFileForImportToBC();
                    
                    self::createAllSetsFileForImportToBC();
                    //var_dump(self::$setsWithOptions['BKY-TOP-BAN-CLS-NFS--PLUS--BKY-BTM-EUR-STR-NFS']);
                break;
            
                default:
                    die();
            }
          
        }
    }

        
    /**
    * authorize
    *
    * 
    *
    *
    */
    private static function auth()
    {
        return true;

    }

    /**
    * authorize
    *
    * 
    *
    *
    */
    private static function getAction()
    {
        if ( isset ( $_REQUEST['action']  ) ) {
            self::$action = $_REQUEST['action'];
        } else {
            die('Nothing to do');                
        }
    }
        
    /**
    * 
    *
    * 
    *
    *
    */        
    private static function getDataForLooks()
    {
      
        $responseArray = array();
            
        $filter = array(
            "availability" => "disabled",
            "is_featured" => "true",
            "limit" => '200'
        );

        $products = BigCommerce_Api::getProducts($filter);
        $productsCount = BigCommerce_Api::getProductsCount();
     
        $emailListOfLooks = '';
        
        $maxProducts = 1;
        $prodCount = 0;

        foreach ($products as $product) {
            $skuSizes = array();
            $skuColours = array();
            $skuStyles = array();
            $skuFits = array();
            $skuDetails = array();
            $imageDetails = array();
            $imageDetailsOtherColors = array();
            
            
            // resize and cache image
            // going to get file contents as well to force cache on api server
            // TODO, move to rackspace.
            $otherColors = array();
              $swapImage = '';
            foreach ($product->images as $image) {
              
                $nameBits = explode ('/' , $image->image_file );
                $name = $nameBits[count($nameBits)-1];
                array_push( $imageDetails , $name );
                
                if ($image->sort_order == 1) {
                      $swapImage = $name;
                     
                }
                
                if ($image->description != '') {
                    if ( isset ( $imageDetailsOtherColors[$image->description] ) ) {
                        array_push( $imageDetailsOtherColors[$image->description] , $name );
                    } else {
                        $imageDetailsOtherColors[$image->description] = array ($name);
                    }
                }
              //  $listImg = file_get_contents('http://api.bikyni.com/thumb/thumb.php?src=http://bikyni.mybigcommerce.com/product_images/'.$image->image_file.'&h=260&zc=true');
              //  self::saveAndSendImageToBC($name , $listImg);
            }
            
            
            $firstColour = $product->images[0]->description;
          
   
            if (isset ( $prodCount  )) {
           //  if ( $prodCount  == 0) {
            $prodCount++;
            $emailListOfLooks = $emailListOfLooks . $product->name . '<br>'; 
                $skus = explode (self::$skuExplode , $product->sku);
                foreach ($skus as $sku) {
                    $sku = trim ($sku);

                    $skuFilters = array(
                        "sku" => $sku
                    );

                    $skuProduct = BigCommerce_Api::getProducts($skuFilters);
                    
                    $skuProduct = $skuProduct[0];

                    foreach ( $skuProduct->custom_fields as $field) {
                        $fieldText = explode ( ',' , $field->text )  ;
                        if (count ($fieldText) > 1) {
                            echo 'more than 2';
                        }
                        foreach ($fieldText as $f ) {
                            $f = trim($f);
                            switch ($field->name) {
                                case 'style':
                                    if (!in_array( $f , $skuStyles) ) {
                                        array_push( $skuStyles, $f );
                                    }
                                break;
                                case 'detail':
                                    if (!in_array( $f , $skuDetails) ) {
                                        array_push( $skuDetails, $f );
                                    }
                                break;
                                case 'fit':
                                    if (!in_array( $f , $skuFits) ) {
                                        array_push( $skuFits, $f );
                                    }
                                break;
                                default:
                            }
                        }
                    }


                    foreach ($skuProduct->skus as $individual) {
                        if ($individual->inventory_level > 0 ) {

                            $els = explode("-" ,$individual->sku );
                            $colour = $els[4];
                            $size = $els[5];

                            if (!in_array( $size , $skuSizes) ) {
                                array_push($skuSizes, $size);
                            }

                            if (!in_array( $colour , $skuColours)) {
                                array_push($skuColours, $colour);
                            }
                        }
                    }
                }
                $thisProd = array(
                    'id' => $product->id,
                    'available_colours'  => $skuColours,
                    'available_sizes'  => $skuSizes,
                    'available_styles'  => $skuStyles,
                    'available_details'  => $skuDetails,
                    'available_fits'  => $skuFits,
                    'images'    => $imageDetails,
                    'imagesOtherColours' => $imageDetailsOtherColors,
                    'color' => $firstColour,
                    'swapImage' => $swapImage
                );
                array_push($responseArray, $thisProd);
            
            
            }
            
        }
            
            
        $products = array('products'=>$responseArray);
        self::$jsonResponse =  'var bkyAvailability = ' . json_encode( $products );

        $emailText = $prodCount.' Looks Processed';
        $emailHTML = '<strong>'.$emailText.'</strong><br>';
        $emailHTML = $emailHTML . $emailListOfLooks;
        $mail = new SendGrid\Mail();
        $mail->
        addTo('andrew@bikyni.com')->
        setFrom('api@bikyni.com')->
        setSubject('[DATA API] - Finished Looks')->
        setText($emailText)->
        setHtml($emailHTML);
        $sendgrid = new SendGrid('discoveredd', 'm1n1eggs');
        $sendgrid->
        web->
        send($mail);

    }
    
    /**
    * 
    *
    * 
    *
    *
    */        
    private static function getProducts($filter)
    {
        
        
         return BigCommerce_Api::getProducts();
         
        
    }
    
    
    private static function convertProductsToJsonBySku () {
       $products = self::$productsData;
       
        foreach ($products as $product) {
            $responseArray = array();
            $responseArray['name'] = $product->name;
            
            $responseArray['images'] =array();
            
            // GRAB IMAGE DATA            
            foreach ($product->images as $image) {
                
                $responseArray['images'][$image->sort_order] = array();                
                $responseArray['images'][$image->sort_order]['image_file'] = $image->image_file;
                $responseArray['images'][$image->sort_order]['description'] = $image->description;
            }
            
      
            self::$jsonResponse =  json_encode( $responseArray ) ;
            $conf = array(
                        'fileName' => $product->sku . '.json',
                        'saveToDir' => 'productsBySku'
                    );
            
            self::saveAndSendToBC($conf);
          
        }
            
            
        
       
       
       
       
    }
    
    private static function SKUGen() {
        
        /* START BY IMPORTING DATA
         * 
         *  SPLIT IN TO PRODUCTS AND SKUS
         * 
         */
        
        $import = 'SKUGen/import/data-skuonly.csv';
        $handle = @fopen($import, "r");
  
        $lineCount = 0;
        $lineMax = 1;
        
         
        $topSKUS = array();
        $bottomSKUS = array();
        $elArrayPositions = array();
        
                
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $line = $buffer;
                $els = explode("," , $line);

                
                if ($lineCount == 0) {
                    $pos = 0;
                    foreach ($els as $el ) {
                        $elArrayPositions[strtolower( trim ( $el ) )] = $pos; 
                        $pos++;
                    }
                    
                } else {
                
                    $name = trim( $els[$elArrayPositions['name'] ]);
                    $sku =  trim( $els[$elArrayPositions['sku'] ]);
                    $availableColours =  trim( $els[$elArrayPositions['colors'] ]);
                    $availableSizes =  trim( $els[$elArrayPositions['sizes'] ]);
                    $description =  trim( $els[$elArrayPositions['description'] ]);

                    $productDetails = array (
                        'SKU'  => $sku,
                        'name' => $name,
                        'availableColours' => $availableColours,
                        'availableSizes' => $availableSizes,
                        'description' => $description
                    );

                    // IS THIS A TOP OR A BOTTOM
                    $type = strpos($sku,'-TOP-');
                    if($type === false) {
                        $bottomSKUS[$sku] = $productDetails; 
                    } else {
                        $topSKUS[$sku] = $productDetails;
                    }
                }
                $lineCount++;
                        
                
            }
            
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }
        
        // NOW CREATE ALL THE PRODUCTS AND THEIR SUB SKUS
        foreach ( $topSKUS as $top ) {
                $baseSKU = str_replace( "-NFS" , "" , $top['SKU'] );
                $configuredSKUS = array();
                $coloursAvailable = explode (" " , trim($top['availableColours']) );
                $sizesAvailable= explode (" " , trim ($top['availableSizes']) );
                foreach ($coloursAvailable as $colour) {
                    $SKUWithColour = $baseSKU . '-' . $colour;
                    foreach ( $sizesAvailable as $size ) {
                        $SKU = $SKUWithColour . '-' . $size;
                        array_push( $configuredSKUS , $SKU );
                    }
                    $topSKUS[$top['SKU']]['SKUS'] = $configuredSKUS;
            }
            $lineCount++;
        } 
        
        foreach ( $bottomSKUS as $bottom ) {
            $baseSKU = str_replace( "-NFS" , "" , $bottom['SKU'] );

            $configuredSKUS = array();
            $coloursAvailable = explode (" " , trim($top['availableColours'] ));
            $sizesAvailable= explode (" " , trim($top['availableSizes']) );
            foreach ($coloursAvailable as $colour) {
                $SKUWithColour = $baseSKU . '-' . $colour;
                
                foreach ( $sizesAvailable as $size ) {
                    $SKU = $SKUWithColour . '-' . $size;
                    array_push( $configuredSKUS , $SKU );
                }
                $bottomSKUS[$bottom['SKU']]['SKUS'] = $configuredSKUS;
            }
            $lineCount++;
        } 
        
        self::$topSKUS = $topSKUS;
        
        self::$bottomSKUS = $bottomSKUS;
        
        
    }
    
    private static function createSets () {
        $skuCount = 1;
        $maxSkuCount = 1;
        foreach ( self::$topSKUS as $topSKU ) {
            
            $topSku = $topSKU['SKU'];
            if ( $topSKU['SKU'] != '') {       
                foreach ( self::$bottomSKUS as $bottomSKU ) {
                    $bottomSku = $bottomSKU['SKU'];
                    
                    if ( $bottomSKU['SKU'] != '') {
                       $setSku =  $topSku . self::$skuExplode . $bottomSku;
                       array_push(self::$nfsSets, $setSku);
                    }
                }
            }
        }
        echo count ( self::$nfsSets ) . ' Not For Sale SKUS created<br><br>';
    }
    
    private static function createOptions () {
        $skuCount = 1;
        $maxSkuCount = 1;
        foreach ( self::$nfsSets as $set ) {
            self::$totalCountDisplayOnly++;
            $setOptions = array();
            
                $bits = explode (self::$skuExplode, $set); 
                $top = $bits[0];
                $bottom = $bits[1];;
                
                $topDetails = self::$topSKUS[$top];
                $bottomDetails = self::$bottomSKUS[$bottom];
                $topSKUS = $topDetails['SKUS'];
                $bottomSKUS = $bottomDetails['SKUS'];
                
                foreach ($topSKUS as $topSKU) {
                    $SKU = $topSKU;
                        
                    foreach ($bottomSKUS as $bottomSKU) {
                        $optionSKU = $SKU . self::$skuExplode . $bottomSKU;
                        array_push( $setOptions , $optionSKU);
                        self::$totalCountDisplayOnly++;
                    }
                    
              

                    
                    
                    
                    
                }
                
                self::$setsWithOptions[$set] = $setOptions;
                
            
            
        }
        
        
    }
    
    private static function createIndividualProductsFileForImportToBC() {
        $fileName = 'individualProducts.csv';     
        $fl = '/bkydatatmp/export/'.$fileName;
        rename($fl, $fl.'.'.time());
        $flh = fopen($fl, 'a') or die("can't open file");
    
        $headerLine = 'headers.csv';
        $headerLinefl = '/bkydatatmp/templates/'.$headerLine;
        $headerLineflh  = file($headerLinefl);
        $headerItem = $headerLineflh[0];
        fwrite($flh, $headerItem ."\n");
        
        $productLine = 'individualProductProduct.csv';
        $productLinefl = '/bkydatatmp/templates/'.$productLine;
        $productLineflh  = file($productLinefl);
        $productLineItem = $productLineflh[0];
        
       
        $skuLine = 'individualProductOption.csv';
        $skuLinefl = '/bkydatatmp/templates/'.$skuLine;
        $skuLineflh  = file($skuLinefl);
        $skuLineItem = $skuLineflh[0];
        
        $products = array_merge((array)self::$topSKUS, (array)self::$bottomSKUS);
        
        foreach ($products as $SKU => $details ) {
            // CREATE PRODUCT
                $thisProduct = $productLineItem;
                $sku = $SKU;
                $name = $details['name'];
                
                
                
                $thisProduct = str_replace("--NAME--", $name,$thisProduct);
                $thisProduct = str_replace("--SKU--", $sku,$thisProduct);
                
                $skuBits = explode('-' , $SKU);
                
                $type = $skuBits[1];
                $img = 'http://api.bikyni.com/img/product_sample/top.jpg';
                if ($type == 'TOP') {
                    $type = 'Tops';
                } else {
                    $type = 'Bottoms';
                    $img = 'http://api.bikyni.com/img/product_sample/bottom.jpg';
                }
                
                $thisProduct = str_replace("--TYPE--", $type,$thisProduct);
                $thisProduct = str_replace("--IMAGE--", $img,$thisProduct);
             
                
                fwrite($flh, $thisProduct."\n");
                
                
                foreach ($details['SKUS'] as $SKU) {
                   $skuBits = explode('-' , $SKU);
                   $type = $skuBits[1];
                   
                   
                
                   
                   
                   
                   if (self::$sizeMap[$skuBits[5]] ) {
                       $size = self::$sizeMap[$skuBits[5]];
                   } else {
                       echo $skuBits[5].' NOT FOUND';
                       die();
                   }
                   
                   if (self::$colorMap[$skuBits[4]] ) {
                       $color = self::$colorMap[$skuBits[4]];
                   } else {
                       echo $skuBits[4].' NOT FOUND';
                       die();
                   }
                    
                   $thisSKU = $skuLineItem;
                   $thisSKU = str_replace("--SIZE--", $size,$thisSKU);
                   $thisSKU = str_replace("--COLOR--", $color,$thisSKU);
                   $thisSKU = str_replace("--SKU--", $SKU,$thisSKU);
                   
                   fwrite($flh, $thisSKU."\n");
                }
                
                
            
        }
        
    }
    
    private static function createAllSetsFileForImportToBC() {
        $fileName = 'productSets.csv';     
        $fl = '/bkydatatmp/export/'.$fileName;
        rename($fl, $fl.'.'.time());
        $flh = fopen($fl, 'a') or die("can't open file");
    
        $headerLine = 'headers.csv';
        $headerLinefl = '/bkydatatmp/templates/sets/'.$headerLine;
        $headerLineflh  = file($headerLinefl);
        $headerItem = $headerLineflh[0];
        fwrite($flh, $headerItem ."\n");
        
        $productLine = 'productLineTemplate.csv';
        $productLinefl = '/bkydatatmp/templates/sets/'.$productLine;
        $productLineflh  = file($productLinefl);
        $productLineItem = $productLineflh[0];
        
        
        $skuLine = 'skuLineTemplate.csv';
        $skuLinefl = '/bkydatatmp/templates/sets/'.$skuLine;
        $skuLineflh  = file($skuLinefl);
        $skuLineItem = $skuLineflh[0];
        
        
        echo $skuLinefl;
        $count = 0;
        echo 'SUMAMRY';
        
        
        foreach ( self::$setsWithOptions as $set => $options ) {
           
            if ($count < 100) {
                // CREATE THE PRODUCT FIRST
                $skuBits = explode(self::$skuExplode , $set);
                $mainTop = $skuBits[0];
                $mainBottom = $skuBits[1];
                
                $name = self::$topSKUS[$mainTop]['name'] . ' ' . self::$bottomSKUS[$mainBottom]['name'];
                $sku = $set;
                $thisProduct = $productLineItem;
                $thisProduct = str_replace("--NAME--", $name,$thisProduct);
                $thisProduct = str_replace("--SKU--", $sku,$thisProduct);
                fwrite($flh, $thisProduct."\n");
                
                $optionCount = 0;
                
                echo '<br>============================<br>';
                echo $set;
                echo '<br><br>';
                echo $name;
            
                // now do the options.
                foreach ($options as $option) {
                    $optionCount++;
                   $skuBits = explode(self::$skuExplode , $option);
                   $topSKU = $skuBits[0]; 
                   $topBits = explode('-' , $topSKU);
                   
                   $bottomSKU = $skuBits[1];
                   $bottomBits = explode('-' , $bottomSKU);
                   
             
                   
                   
//                  / var_dump($topBits);
                   
                  
                   if (self::$sizeMap[$topBits[5]] ) {
                       $topSize = self::$sizeMap[$topBits[5]];
                   } else {
                       echo $topBits[5].' NOT FOUND';
                       die();
                   }
                   
                   if (self::$colorMap[$topBits[4]] ) {
                       $topColor = self::$colorMap[$topBits[4]];
                   } else {
                       echo $topBits[4].' NOT FOUND';
                       die();
                   }
                   
                   if (self::$sizeMap[$bottomBits[5]] ) {
                       $bottomSize = self::$sizeMap[$bottomBits[5]];
                   } else {
                       echo $bottomBits[5].' NOT FOUND';
                       die();
                   }
                   
                   if (self::$colorMap[$bottomBits[4]] ) {
                       $bottomColor = self::$colorMap[$bottomBits[4]];
                   } else {
                       echo $bottomBits[4].' NOT FOUND';
                       die();
                   }
                   
                   
                   $thisSKU = $skuLineItem;
                   $thisSKU = str_replace("--SIZE-TOP--", $topSize,$thisSKU);
                   $thisSKU = str_replace("--SIZE-BOTTOM--", $bottomSize,$thisSKU);
                   $thisSKU = str_replace("--COLOR-TOP--", $topColor,$thisSKU);
                   $thisSKU = str_replace("--COLOR-BOTTOM--", $bottomColor,$thisSKU);
                   $thisSKU = str_replace("--SKU--", $option,$thisSKU);
                   
                   fwrite($flh, $thisSKU."\n");
                   
                }
                
                echo '<br><br>Total Options - '.$optionCount.'<br><br>';
                
             
            }
            
                $count++;
     
        }
        
        echo '<br>============================<br>';  
        
        echo 'TOTAL OPTIONS: '.$count;
        
        
     
    
         
         
       
        fclose($flh);
      
        
    }
    
    /**
    * authorize
    *
    * 
    *
    *
    */
    private static function saveAndSendToBC($conf)
    {
        // Save Local Copy
        // TODO: do not overwrite the file, rename and redo.
        $fileName = $conf['fileName'];        
        $fl = '/bkydatatmp/'.$conf['fileName'];
        
        rename($fl, $fl.'.'.time());
        
        $flh = fopen($fl, 'w') or die("can't open file");
        
        
        fwrite($flh, self::$jsonResponse );
        
        fclose($flh);
      

        // Now move it the the biog commerce server.
        // set up basic ssl connection
            
        $conn_id = ftp_ssl_connect(self::$ftp_server);
        // login with username and password
        $login_result = ftp_login($conn_id, self::$ftp_user_name, self::$ftp_user_pass);
        $remoteFile = '/content/data/'.$conf['saveToDir'].'/'.$fileName;
        $newFile = $remoteFile.'.'.time();
        // try to rename $old_file to $new_file
        ftp_rename($conn_id, $remoteFile, $newFile);
        ftp_put($conn_id,$remoteFile, $fl, FTP_BINARY);
        
        ftp_close($conn_id);
    }
    
     /**
    * authorize
    *
    * 
    *
    *
    */
    private static function saveAndSendImageToBC($name , $img)
    {
        // Save Local Copy
        // TODO: do not overwrite the file, rename and redo.
        $fileName = $name;        
        $fl = '/bkydatatmp/product_images/'.$fileName;
      //  rename($fl, $fl.'.'.time());
        $flh = fopen($fl, 'w') or die("can't open file");
        fwrite($flh, $img );
        fclose($flh);
                // Now move it the the biog commerce server.
        // set up basic ssl connection
            
        $conn_id = ftp_ssl_connect(self::$ftp_server);
        // login with username and password
        $login_result = ftp_login($conn_id, self::$ftp_user_name, self::$ftp_user_pass);
        $remoteFile = '/content/product_images/'.$fileName;
        $newFile = $remoteFile.'.'.time();
        // try to rename $old_file to $new_file
       // ftp_rename($conn_id, $remoteFile, $newFile);
        ftp_put($conn_id,$remoteFile, $fl, FTP_BINARY);
        ftp_close($conn_id);
    }
    /*
     * TESTS
     * 
     * 
     */
    private static function testShowGeneratedSKUS () {
        foreach (self::$bottomSKUS as $bottom) {
            var_dump($bottom);
            echo ('<br><br><br><br>');
            
        }
    }
    
    private static function testSetsWithOptions () {
        $count = 1;
        echo 'test started';
        foreach (self::$setsWithOptions as $set) {
            if ($count == 1) {
                var_dump($set);
                echo $count;
                echo '<br>---------';

            }
            
            $count++;
            
        }
        
    }
    
}
