#  Module Mind Import

    ``mind/module-import-customer``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Get Customer import from file input from command line

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Mind`
 - Enable the module by running `php bin/magento module:enable Mind_ImportCustomer`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 -  the module available in a composer repository for :
    
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require mind/module-import`
 - enable the module by running `php bin/magento module:enable Mind_ImportCustomer`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration




## Specifications

 - Console Command
	- Import
    -it better to save file in var folder therefore path should be like this e.g
      /var/sample.csv
      /var/sample.json
     
      OR
      
      -if save file on base root save file e.g
     
    <code>  {root}sample.csv
      {root}sample.json </code>
     
    - So to import from the CSV and the JSON respectively the user would execute either one of the following
      
       
     <code>php bin/magento customer:import sample-csv sample.csv
     php bin/magento customer:import sample-json sample.json
## Attributes



