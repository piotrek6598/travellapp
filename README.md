# Aplikacja Turystyczna "Na końcu świata"

Aplikacja turystyczna “Na krańcu świata” jest narzędziem pomagającym zaplanować podróż. Wskazuje najciekawsze atrakcje które warto zobaczyć. Pomaga znaleźć miejsce noclegowe odpowiednie dla naszego budżetu. Informuje o pogodzie, a także prezentuje aktualne ostrzeżenia Ministerstwa Spraw Zagranicznych dotyczących odwiedzanego kraju. 

## Uruchomienie własnej kopii strony

Do postawienia strony potrzebna jest maszyna linuxowa z serwerem www i php. Dodatkowo należy zainstalować interpreter pythona3 wraz z menedżerem pakietów pip. Do poprawnego działania strony potrzebne są pakiety *googlemaps*, *PyAML*, *requests*, *numpy* i *selenium*. Dodatkowo do prawidłowego działania wyszukiwarki miejsc noclegowych potrzebna jest przeglądarka Chrome, a także Chromedriver do pobrania ze [strony](https://chromedriver.chromium.org/). Dodatkowo w pliku *accomodation.py* należy w 17. linijce ustawić ścieżkę do pobranego Chromedrivera. 

Przykładowo w katalogu domowym należy
```
mkdir public_html
```
następnie umieścić tam katalog ze sklonowanym repozytorium (o nazwie np travellapp-master) i wywołać
```
php -S localhost:8000 -t travellapp-master
```
Umożliwia to dostęp do aplikacji z przeglądarki przy pomocy localhost:8000
