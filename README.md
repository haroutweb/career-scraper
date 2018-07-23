Implementation
========================
Scraper use PHP for backend and vue.js for frontend.
I have created custom framework for this solution.

Backend part of application consist with 3 native modules (Framework, Scraper, Recruitment) and 2 external libraries (twig, fabpot/goutte).

* `Framework` is a framework core module.
* `Scraper` is a module for scraping.
* `Recruitment` is a module for http response.
* `Twig` is a template engine.
* `fabpot/goutte` is a dom-crawler module created by Fabien Potencier (Symfony author).

`Framework` can response to cli and http requests equally.
`CareerCenter` is a service for `Scraper` module and we can implement more other services.
I have implemented file storage binary style architecture in folder `storage` for scalability.
Application scraping and save listing, records separately.

Frontend part is implemented via vue.js(2 version).
I have chosen a simple style of vue.js structuring and used webpack to build single js file which is been attached in main layout.html.
This approach let me use es6 module structuring in frontend part.

The simple webpack configuration builds a single "bundle.js" file in "public/dist/js" folder, which is attached in main "layout.twig" file.
To build a file you need to have node.js(preferable latest version) installed.
I have created One main smart component "app", which includes "header", "bar" and "content" components.

* The `header` component is dummy component which shows static header.
* The `bar` component gets the career center list data after it has been created and shows the list of data. After clicking on item, the "bar" component emits (sends) item  id to his parent "app" component, which is responsible for getting item's data and passing it to "content" component.
* The `content` is dummy component, which shows item's data after receiving that data from parent "app" component.

P.S. I have got acquainted with vue.js today, please don't criticize :)


Installation Guide
========================

When it comes to installing the application, you have the following options.

### Use Composer (*important*)

    composer install
    composer dump-autoload --optimize

### Create storage (*important*)

    mkdir storage
    chmod -R 0777 storage

### Install npm modules (*important*)

    npm install
    npm run build

### Nginx configuration (*important*)

    server {
        listen              80;
        server_name         local.scraper-php local.scraper-php;

        root                /var/projects/scraper-php/public;
        index               index.php;

        location / {
            try_files $uri $uri/ /index.php$is_args$args;
        }

        rewrite ^/(.*)/$ /$1 permanent;

        if (!-e $request_filename) {
            rewrite ^.*$ /index.php last;
        }

        location ~ \.php$ {
            fastcgi_pass   unix:/var/run/php/php7.1-fpm.sock;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME $document_root/index.php;
            fastcgi_param  APPLICATION_ENV development;
            fastcgi_param  APPLICATION_ENV production;
            include        fastcgi_params;
        }

        location ~* ^/.+\.(php)|/.+\.(php)/.+$ {
            return $scheme://$host/404;
        }

        location ~ ^/js {
                deny all;
                return 404;
        }

        location ~* \.(jpg|jpeg|gif|png|ico|css|bmp|swf|js|html|txt|eot|woff|woff2|ttf)$ {
            root /var/projects/scraper-php/public;
            expires 30d;
            add_header Cache-Control "public";
        }

        access_log /var/log/nginx/local.scraper-php.log main;
        error_log  /var/log/nginx/local.scraper-php.log warn;
    }


Browsing the Demo Application
========================

Scrape data from careercenter.am

    php application/console scraper:list:careercenter
    php application/console scraper:records:careercenter:[limit]

Open in local environment

    local.scraper-php
