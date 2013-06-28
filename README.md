Simple HTTP Redirector
=========================================

## What is it ?
It's a small bundle but with great functionnalities, it redirects your incoming urls from  old pages to new's one.
You need just to write your conf redirection file in yaml format like:

```
#app/config/redirected_urls.yml

url1:
    from: "/first-url-to-redirect" #required
    to: "/redirect-destination"    #required
    http_code: 301         #optionnal 
    host: http:/www.my-new-website.com  #optionnal
url2:
    from: "/articles/1220"
    to: "/articles/how-to-write-a-redirected-file.html" #SEO optimization
    http_code: 302
```

### Step 1: Install bundle using composer
``` js
{
    "require": {
        // ...
        "skonsoft/redirector-bundle": "dev-master"
    }
}
```
### Step 2: Register the bundle

```
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Skonsoft\Bundle\RedirectorBundle\SkonsoftRedirectorBundle(),
    );
    // ...
}
```

### Step 3: Write your config redirected urls

Create a new file inside app/config called 'redirected_urls.yml' and save urls you want to redirect inside it.

Note that you can use any other file name and path, just override 'skonsoft_redirector.redirection_source_file' in your config.yml

```
#app/config.yml
parameters:
    skonsoft_redirector.redirection_source_file: %kernel.root_dir%/config/redirected_urls.yml
```

### Step 4: Clear cache

Clear your cache and enjoy !