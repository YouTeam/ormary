<?php

class ControllerProductCategory extends Controller {

    public function index() {
        $this->language->load('product/category');

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        if (isset($this->request->get['filter'])) {
            $filter = $this->request->get['filter'];
        } else {
            $filter = '';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'p.sort_order';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = $this->config->get('config_catalog_limit');
        }

        $this->data['bodyClass'] = 'category';




        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

        if (isset($this->request->get['path'])) {
            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $path = '';

            $parts = explode('_', (string) $this->request->get['path']);

            $category_id = (int) array_pop($parts);

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int) $path_id;
                } else {
                    $path .= '_' . (int) $path_id;
                }

                $category_info = $this->model_catalog_category->getCategory($path_id);

                if ($category_info) {
                    $this->data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('product/category', 'path=' . $path . $url),
                        'separator' => $this->language->get('text_separator')
                    );
                }
            }
        } else {
            $category_id = 0;
        }



        if (isset($this->request->get['featured']) && $this->request->get['featured'] == 1) {
            $category_info = array('name' => "What's new", 'meta_description' => '', 'meta_keyword' => '', 'image' => false, 'description' => '');
        } else {
            if ($category_id != 0) {
                $category_info = $this->model_catalog_category->getCategory($category_id);
            } else {
                $category_info = array('name' => 'Search results', 'meta_description' => '', 'meta_keyword' => '', 'image' => false, 'description' => '');
            }
        }

        if ($category_info || $category_id == 0) {
            $this->document->setTitle($category_info['name'] . ' | Ormary.com');
            $this->document->setDescription($category_info['meta_description']);
            $this->document->setKeywords($category_info['meta_keyword']);
            $this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');
            $this->document->addScript('catalog/view/javascript/ormary-js/iscroll.js');
            $this->data['heading_title'] = $category_info['name'];
            $this->data['text_refine'] = $this->language->get('text_refine');
            $this->data['text_empty'] = $this->language->get('text_empty');
            $this->data['text_quantity'] = $this->language->get('text_quantity');
            $this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $this->data['text_model'] = $this->language->get('text_model');
            $this->data['text_price'] = $this->language->get('text_price');
            $this->data['text_tax'] = $this->language->get('text_tax');
            $this->data['text_points'] = $this->language->get('text_points');
            $this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            $this->data['text_display'] = $this->language->get('text_display');
            $this->data['text_list'] = $this->language->get('text_list');
            $this->data['text_grid'] = $this->language->get('text_grid');
            $this->data['text_sort'] = $this->language->get('text_sort');
            $this->data['text_limit'] = $this->language->get('text_limit');

            $this->data['button_cart'] = $this->language->get('button_cart');
            $this->data['button_wishlist'] = $this->language->get('button_wishlist');
            $this->data['button_compare'] = $this->language->get('button_compare');
            $this->data['button_continue'] = $this->language->get('button_continue');

            // Set the last category breadcrumb		
            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $this->data['breadcrumbs'][] = array(
                'text' => $category_info['name'],
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path']),
                'separator' => $this->language->get('text_separator')
            );

            if ($category_info['image']) {
                $this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
            } else {
                $this->data['thumb'] = '';
            }

            $this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            $this->data['compare'] = $this->url->link('product/compare');

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }


            $subcategories_list = array();

            $this->data['categories'] = array();

            $results = $this->model_catalog_category->getCategories($category_id);

            foreach ($results as $result) {

                /* 				$data = array(
                  'filter_category_id'  => $result['category_id'],
                  'filter_sub_category' => true
                  );

                  $product_total = $this->model_catalog_product->getTotalProducts($data);

                  $this->data['categories'][] = array(
                  'name'  => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
                  'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
                  ); */


                $subcategories_list[] = $result['category_id'];
            }

            //$this->data['search_filter'] = $this->model_catalog_product->getFilterOptions(0);
            //print_r($this->data['search_filter']);

            $this->data['products'] = array();
            $this->request->get = $this->validateSearchParams($this->request->get);

            /* ---------- Search params ------------- */

            if (isset($this->request->get['price_top'])) {
                $url .= '&price_top=' . $this->request->get['price_top'];
                $price_top = $this->request->get['price_top'];
            } else {
                $price_top = '';
            }

            if (isset($this->request->get['price_low'])) {
                $url .= '&price_top=' . $this->request->get['price_low'];
                $price_low = $this->request->get['price_low'];
            } else {
                $price_low = '';
            }

            if (isset($this->request->get['rd_year'])) {
                $url .= '&rd_year=' . $this->request->get['rd_year'];
                $rd_year = $this->request->get['rd_year'];
            } else {
                $rd_year = '';
            }

            if (isset($this->request->get['rd_month'])) {
                $url .= '&rd_month=' . $this->request->get['rd_month'];
                $rd_month = $this->request->get['rd_month'];
            } else {
                $rd_month = '';
            }
            $designer = '';
            if (isset($this->request->get['designer'])) {
                $url .= '&designer=' . $this->request->get['designer'];
                $designer = $this->request->get['designer'];
            } else {
                $dname = '';
            }

            if (isset($this->request->get['color'])) {
                $url .= '&color=' . $this->request->get['color'];
                $color = $this->request->get['color'];
            } else {
                $color = '';
            }

            if (isset($this->request->get['size'])) {
                $url .= '&size=' . $this->request->get['size'];
                $size = $this->request->get['size'];
            } else {
                $size = '';
            }

            if (isset($this->request->get['search_phrase'])) {
                $url .= '&search_phrase=' . $this->request->get['search_phrase'];
                $search_phrase = $this->request->get['search_phrase'];
            } else {
                $search_phrase = '';
            }


            $this->data['search_phrase'] = $search_phrase;

            $data = array(
                'filter_category_id' => $category_id,
                'filter_filter' => $filter,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit,
                /* --------------- Search params ---------------- */
                'price_top' => $price_top,
                'price_low' => $price_low,
                'rd_year' => $rd_year,
                'rd_month' => $rd_month,
            
                'color' => $color,
                'size' => $size,
                'filter_category_ids_list' => $subcategories_list,
                'filter_name' => $search_phrase,
                'filter_description' => $search_phrase,
                 'search_phrase' => $search_phrase,
                                'filter_status' => 1,
            );

if (  $designer > -1) {
    $data['designer'] = $designer;
}
          
            $product_total = $this->model_catalog_product->getTotalProducts($data);

   
            
            $this->data['total_products'] = $product_total;

            $results = $this->model_catalog_product->getProducts($data);

            foreach ($results as $result) {

                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
                } else {
                    $image = $this->model_tool_image->resize("no_image.png", $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height')); //"catalog/view/theme/ormary/images/no_image.png";//
                }

                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }

                if ((float) $result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float) $result['special'] ? $result['special'] : $result['price']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = (int) $result['rating'];
                } else {
                    $rating = false;
                }

                $this->load->model('catalog/manufacturer');
                $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($result['manufacturer_id']);


                if (count($result['extraimages']) > 1) {
                    $swapimage = $this->model_tool_image->resize($result['extraimages'][count($result['extraimages']) - 1]['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
                } else {
                    $swapimage = '';
                }



                $this->data['products'][] = array(
                    'product_id' => $result['product_id'],
                    'thumb' => $image,
                    'name' => $result['name'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
                    'price' => $price,
                    'special' => $special,
                    'tax' => $tax,
                    'rating' => $result['rating'],
                    'reviews' => sprintf($this->language->get('text_reviews'), (int) $result['reviews']),
                    'href' => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url),
                    'extraimage' => $swapimage,
                    'manufacturer_name' => $manufacturer_info['name'],
                );
            }

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $this->data['sorts'] = array();

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_default'),
                'value' => 'p.sort_order-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_name_asc'),
                'value' => 'pd.name-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_name_desc'),
                'value' => 'pd.name-DESC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_price_asc'),
                'value' => 'p.price-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_price_desc'),
                'value' => 'p.price-DESC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
            );

            if ($this->config->get('config_review_status')) {
                $this->data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_desc'),
                    'value' => 'rating-DESC',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
                );

                $this->data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_asc'),
                    'value' => 'rating-ASC',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
                );
            }

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_model_asc'),
                'value' => 'p.model-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_model_desc'),
                'value' => 'p.model-DESC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
            );

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            $this->data['limits'] = array();

            $limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

            sort($limits);

            foreach ($limits as $value) {
                $this->data['limits'][] = array(
                    'text' => $value,
                    'value' => $value,
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
                );
            }

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }



            $pagination = new Pagination();
            $pagination->total = $product_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
             $pagination->search_phrase = $search_phrase;
            $pagination->text = $this->language->get('text_pagination');

            if (isset($this->request->get['featured'])) {

                $pagination->url = 'new' . $url . '&page={page}';

                $url .= '&featured=' . $this->request->get['featured'];
            } else if ($search_phrase != '') {
            
                $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}&search_phrase='.$search_phrase.'');
                
            } else {

                $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
            }
            $this->data['pagination'] = $pagination->renderCatalogPager();

            $this->data['sort'] = $sort;
            $this->data['order'] = $order;
            $this->data['limit'] = $limit;

            $this->data['continue'] = $this->url->link('common/home');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/product/category.tpl';
            } else {
                $this->template = 'default/template/product/category.tpl';
            }

            $this->children = array(
                'common/column_left',
                'common/column_right',
                'common/content_top',
                'common/content_bottom',
                'common/footer',
                'common/header'
            );

            $this->response->setOutput($this->render());
        } else {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('product/category', $url),
                'separator' => $this->language->get('text_separator')
            );

            $this->document->setTitle($this->language->get('text_error'));

            $this->data['heading_title'] = $this->language->get('text_error');

            $this->data['text_error'] = $this->language->get('text_error');

            $this->data['button_continue'] = $this->language->get('button_continue');

            $this->data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
            } else {
                $this->template = 'default/template/error/not_found.tpl';
            }

            $this->children = array(
                'common/column_left',
                'common/column_right',
                'common/content_top',
                'common/content_bottom',
                'common/footer',
                'common/header'
            );

            $this->response->setOutput($this->render());
        }
    }

    private function validateSearchParams($data) {
        if (isset($data['price_top'])) {
            $this->request->get['price_top'] = (int) $this->request->get['price_top'];
        }


        if (isset($this->request->get['price_low'])) {
            $this->request->get['price_low'] = (int) $this->request->get['price_low'];
        }


        if (isset($this->request->get['rd_year'])) {
            $this->request->get['rd_year'] = (int) $this->request->get['rd_year'];
        }

        if (isset($this->request->get['rd_month'])) {
            $this->request->get['rd_month'] = $this->db->escape($this->request->get['rd_month']);
        }

        if (isset($this->request->get['dname'])) {
            $this->request->get['dname'] = $this->db->escape($this->request->get['dname']);
        }

        if (isset($this->request->get['color'])) {
            $this->request->get['color'] = (int) $this->request->get['color'];
        }

        if (isset($this->request->get['size'])) {
            $this->request->get['size'] = (int) $this->request->get['size'];
        }

        return $data;
    }

}

?>