### laravel admin website test, ukážka kódu v 01
- autor: Martin Fehér

Ukážka admin website zóna v Laravel php frameworku:

* 2 typy účtov - user a admin

* admin vie vytvárať nových userov/adminov, pričom user/admin má login, email a pri vytvorení usera príde danému userovi/adminovi na mail linka na vytvorenie hesla

* user/admin si teda vytvorí heslo, pričom heslo musí obsahovať minimálne 8 znakov, aspoň jedno veľké a malé písmeno a aspoň jeden znak  z nasledujúcich znakov: .,#@!+-%&()_

* pokiaľ pri vytváraní usera/admina už existuje user/admin s loginom alebo emailovou adresou, tak pomocou AJAXU je na to admin upozornený už pri vypĺňaní formulára pre vytváranie užívateľov

* admin vie usera aj zmazať

* user alebo admin vie vytvárať a editovať produkty (číselník produktov), pričom produkt má názov, rich text popis a cenu

* user vie vytvárať objednávky, pričom objednávka obsahuje názov, popis a možnosť nahrávať obrázky alebo dokumenty (JPG, PNG, DOC, DOCX, PDF)

* okrem toho do objednávky je možné pridať existujúce produkty

* User vidí a môže editovať len svoje objednávky

* Admin vidí všetky objednávky a vidí aj informáciu kto a kedy danú objednávku vytvoril

Po vypracovaní zadania ma prosím informujte a poskytnem Vám repozitár na commitnutie kódu.
</p>


###Požiadavky/Requirements
- PHP version/verzia >= 7.3
- Composer dependency manager. Inštalácia/Installation: https://getcomposer.org/download/

###Inštalácia/Installation
- mkdir repository
- git clone https://github.com/martinfeher/laravel-test-admin-website-v01.git
- cd repository
- composer install
- php artisan cache:clear; php artisan config:cache;
- (additional/ dodatočné) .env file, database structure file can be sent on request / vhodný .env súbor, súbor so štruktúrou databázy je zaslaný na požiadanie
