# Changelog — Weblix Elementor Plugins

## 1.2.2 — Test aktualizatora

### Zmiany
- Test mechanizmu auto-update przez WP Admin.

## 1.2.1 — Fix: aktualizator GitHub (rate limit)

### Poprawki
- **Fix: błąd 403 przy sprawdzaniu aktualizacji** — wbudowany token bez uprawnień (zero scopes) omija limit GitHub API na serwerach współdzielonych. Nie wymaga konfiguracji wp-config.php.

## 1.2.0 — Wave Ticker: płynna fala po wyrazach

### Wave Ticker widget
- **Poprawa animacji fali** — faza fali bazuje teraz na pozycji X znaku na ekranie (spatial wave). Sąsiednie litery mają prawie identyczne przesunięcie Y, dzięki czemu całe wyrazy i frazy płyną jako jedna gładka fala zamiast każdej litery animować się niezależnie.

## 1.1.0 — Wave Ticker: pełna stabilizacja

### Wave Ticker widget
- **Fix: emoji niewidoczne** — WordPress emoji JS używa MutationObserver który konwertował każde emoji w DOM na `<img class="emoji">` ze złymi wymiarami. Rozwiązanie: emoji przechowywane w `data-emoji` atrybucie i renderowane przez CSS `::before { content: attr(data-emoji) }` — WP emoji nie rusza atrybutów.
- **Fix: tekst nie wypełniał pełnej szerokości** — liczba klonów tekstu jest teraz dynamicznie obliczana na podstawie `el.offsetWidth`, rebuild przy resize okna.
- **Fix: seamless loop** — `oneWidth` mierzony przez `getBoundingClientRect()` po wyrenderowaniu DOM zamiast z `scrollWidth / 2`.
- **Nowa kontrolka: Odstęp między powtórzeniami (px)** — domyślnie 0 (brak przerwy).
- **Cache-busting** — wersja CSS/JS przez `filemtime()` zamiast statycznego stringa.
- **Tekst w `data-text`** — PHP umieszcza treść w atrybucie zamiast jako innerHTML, co zapobiega ingerencji WP emoji przed inicjalizacją JS.

## 1.0.0 — Wave Ticker: pierwsze wydanie

### Nowe widgety
- **Wave Ticker** — przewijający się tekst w loopie z animacją sinusoidalną per znak (requestAnimationFrame). Kontrolki: tekst, prędkość przewijania, amplituda fali, częstotliwość fali, prędkość fali, kolor, typografia, tło, padding.
