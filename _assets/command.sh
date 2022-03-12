?templatehints=magento
php bin/magento s:up && php bin/magento s:d:c && php bin/magento s:s:d en_US ar_SA --exclude-theme Magento/luma --exclude-theme Magento/blank -f  && echo -ne '\007' && htop


php bin/magento s:up && php -dmemory_limit=2G bin/magento s:s:d -f  && htop
php bin/magento s:up && php -dmemory_limit=2G bin/magento s:s:d -f
rm -rf var/view_processed/ pub/static/* generation/
bin/magento setup:config:set --enable-debug-logging=true
bin/magento dev:query-log:enable
### --------------------------Deployment Production Producer-------------------------------------------
php bin/magento setup:db-declaration:generate-patch Mind_GuestRegister CreateCustomerAttribute
#SERVER INFO
cd htdocs/test1.sportscorner.qa/current/
cd htdocs/test.sportscorner.qa/current/
###----------------------DISABLEED
php bin/magento deploy:mode:set developer
php bin/magento deploy:mode:set default
php bin/magento deploy:mode:set production -s
php bin/magento deploy:mode:show
php bin/magento catalog:image:resize
php bin/magento c:c
php bin/magento c:f
php bin/magento s:d:c
php bin/magento indexer:reindex
php -dmemory_limit=2G  bin/magento setup:di:compile

php bin/magento s:s:d en_US ar_SA
php bin/magento s:s:d --theme Magento/backend --theme Smartwave/scChild en_US ar_SA -f
php bin/magento s:up --keep-generated
php  -dmemory_limit=2G bin/magento setup:static-content:deploy
php  -dmemory_limit=2G bin/magento setup:static-content:deploy en_US ar_SA -f

php bin/magento module:enable Mind_GuestRegister
php bin/magento module:enable Magento_Downloadable Magento_GiftMessage
php bin/magento module:enable Magento_GiftMessage
php bin/magento module:disable Searchanise_SearchAutocomplete
php bin/magento module:enable Searchanise_SearchAutocomplete
php bin/magento module:disable Mind_Importexportcategory
php bin/magento module:disable Mind_Employee
php bin/magento module:disable Techvista_Sales
php bin/magento module:disable Techvista_Checkout
php bin/magento module:disable Techvista_Catalog
php bin/magento module:disable Aheadworks_StoreCredit
php bin/magento module:enable Amasty_Shopby

#Cloud Flare set on Development

#MYSQL COMMAND LINE
mysql -u bssqatar_rasen -p bssqatar_rasen

php bin/magento module:uninstall Faonni_Price
### ---------------------------------------------------------------------


# https://magento.stackexchange.com/questions/88242/magento-2-xml-validation
# Check updates to the GitHub today, Magento 2 introduced new command to automatically generate all the URN resolutions for the PhpStorm.
php bin/magento dev:urn-catalog:generate .idea/misc.xml
#new user
php bin/magento admin:user:create --admin-user=haroonmind --admin-password=Admin123456! --admin-email=haroonmind@gmail.com --admin-firstname=Haroon --admin-lastname=khan
php bin/magento admin:user:create --admin-user=haroonmind --admin-password=Admin123456! --admin-email=haroonmind@gmail.com --admin-firstname=Haroon --admin-lastname=khan

admin2
haroonmind
Admin123456!
php bin/magento admin:user:create --admin-user=admin3 --admin-password=Admin123456!

session.save_handler = files
session.save_path = "var/www/shopatregal.com/public_html/session"

### --------------------------BASH-------------------------------------------
# search text from all over the server space
grep -r Go to Showroom *
grep -r woocommerce-notices-wrapper *

### Navigate Directory
To navigate into the root directory, use "cd /"
To navigate to your home directory, use "cd" or "cd ~"
To navigate up one directory level, use "cd .."
To navigate to the previous directory (or back), use "cd -"

# FOR COPY :
cp [OPTION] Source Destination
cp [OPTION] Source Directory
cp [OPTION] Source-1 Source-2 Source-3 Source-n Directory
cp -a  pub/static/. pub/static_bkp/
cp -a ../public_html/pub/media/catalog/product/. pub/media/catalog/product/
cp -a app/code/* ../dev5/app/code -R
cp -a /home/cloudpanel/htdocs/test1.test/Magento-2-main/* /home/cloudpanel/htdocs/test1.test/ -R
cp -a  /Magento-2-main ./Magento-2-main

. means current folder.
.. means parent folder of the current folder.
* means copy everything from the current folder (wildcard).
-R means copy folders and files in inside them recursively.
cp -a pub/static_4_22_2020/.  pub/static/
cp -a  scChild/. scChild_rtl/

#FOR Remove

rm -i will ask before deleting each file. Some people will have rm aliased to do this automatically (type "alias" to check). Consider using rm -I instead, which will only ask once and only if you are trying to delete three or more files.
rm -r will recursively delete a directory and all its contents (normally rm will not delete directories, while rmdir will only delete empty directories).
rm -f will forcibly delete files without asking; this is mostly useful if you have rm aliased to ``rm -i'' but want to delete lots of files without confirming each one.

#----------------------------FOR DEPLOY----------------------------------------
#BASH NAME
--name mgt-dev-72
#----------------------------CHANGE FILE PERMISSION AND OWNER SHIP---------------------------------------
sudo chown clp:root * -R :super user do
sudo chown -R <Magento user>:<web server group> .
sudo chown admin:root * -R   :change owner
chmod -cR 777 .       :change owner
su - clp
sudo chown root:clp * -R
sudo chmod -R 777 var/
sudo chmod -R 777 generated/
find . -type f -exec chmod 664 {} \;
find . -type d -exec chmod 775 {} \;
find var generated vendor pub/static pub/media app/etc -type f -exec chmod g+w {} +
find var generated vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} +
#Execute these commands as a root user. If you have already given 777 permission revert it using first two commands else proceed with the rest.


#----------------------------USEFUL COMMANDS FOR MAGNETO---------------------------------------
tail -f var/log/*.log
tail -f var/log/system.log
show all log files current changes
tail  -n 15 filename.ext

mv  -v /Magento-2-main/* ./
#--------------------------------ZIP LINUX:----------------------------------------
#Install Zip on Ubuntu and Debian #
sudo apt install zip
#Install Zip on CentOS and Fedora
sudo yum install zip

zip -r hrlive_12_20_2020.zip hrlive

unzip file.zip -d destination_folder

#--------------------------------GIT:----------------------------------------


git add -A stages all changes
git add . stages new files and modifications, without deletions
git add -u stages modifications and deletions, without new files

git commit -m "Update Amasty and Swissup Plugin "
git push origin magento_2_3_4

git pull origin magento_2_3_4
git clone -b magento_2_3_4 https://github.com/VisionetSystemsInc/tbg.git

git merge dev --allow-unrelated-histories

https://stackoverflow.com/questions/7217894/moving-changed-files-to-another-branch-for-check-in
git cherry-pick SHA
git reset HEAD~1
grep -r wk-discount-percent *
wk-discount-percent

#GET OLD FILE FROM PERVIOUS COMMIT
git checkout 08618129e66127921fbfcbc205a06153c92622fe path/to/file.txt
git checkout 666f80a4d459c55d86715d36e3c62b2cc935ac97 app/design/frontend/Smartwave/scChild/web/css/custom_main.css

#--------------------------------MYSQL----------------------------------------
mysql -u sportscor-test -p

#1. Back up the database using the following command:

mysqldump -u [username] –p[password] [database_name] > [dump_file.sql]
mysqldump -u scqatar_dev4 –pscqatar_dev4 scqatar_dev4 > scqatar_dev4_1_31_2021_mind.sql

# 2. Restore the backup to a local database server - the mysql command will let you take the contents of a .sql file backup, and restore it directly to a database. This is the syntax for the command:

mysql -u [username] –p[password] [database_name] < [dump_file.sql]


# --------------------Install Magento Through Command line -------------------------------------
php bin/magento setup:install --base-url=http://project.magento/ \
--db-host=localhost --db-name=magento --db-user=root --db-password=root \
--admin-firstname=Magento --admin-lastname=User --admin-email=user@example.com \
--admin-user=haroonmind --admin-password=Admin123456! --language=en_US \
--currency=USD --timezone=America/Chicago --use-rewrites=1 \
--search-engine=elasticsearch7 --elasticsearch-host=es-host.example.com \
--elasticsearch-port=9200

https://magentip.com/install-magento-2-4-x-on-ubuntu-with-elasticsearch/

bin/magento setup:install \
--base-url=http://mywebsite.com \
--db-host=localhost \
--db-name=m2lite \
--db-user=admin \
--db-password=Admin123456! \
--admin-firstname=Admin \
--admin-lastname=Admin \
--admin-email=haroonmind@gmail.com \
--admin-user=admin \
--admin-password=admin123456! \
--language=en_US \
--currency=USD \
--timezone=America/Chicago \
--use-rewrites=1



composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition=2.3.5


# PSR2
#PSR4
phpcs --standard=PSR2 /path/to/code-directory
phpcs --standard=PSR4 /path/to/code-directory