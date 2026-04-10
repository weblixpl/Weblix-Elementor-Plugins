# Changelog — Weblix Elementor Plugins

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
