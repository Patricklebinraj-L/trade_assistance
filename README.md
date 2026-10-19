# BTC Intelligence Platform

Beginner-friendly BTC market intelligence and risk planner for Delta Exchange. Stack: HTML5, CSS3, JavaScript, jQuery, PHP 8.2+, MySQL/PDO and TradingView Lightweight Charts. No Composer or Node runtime is required.

## Safety / scope
- Analysis and paper-planning only. No live order placement, cancellation or execution code is included.
- Public market data requires no Delta API key. Leave `DELTA_API_KEY` and `DELTA_API_SECRET` blank for this release.
- Never put API secrets in frontend JS, source control or chat.
- No AI or strategy guarantees profits. Stale/unavailable feeds must not be treated as live prices.
- **Verify your exact Delta product.** Delta India derivatives commonly use `BTCUSD`; it may be quoted in USD and settled/margined according to the product specification, not be a literal BTC/USDT spot instrument. Set `DELTA_SYMBOL` to the exact symbol in your account and verify product ID, multiplier, settlement currency, min size and margin before relying on P&L estimates.

## Requirements
PHP 8.2+ (`curl`, `pdo_mysql`, `json`, `mbstring` recommended), MySQL 8+/compatible MariaDB, Apache `mod_rewrite` (optional for pretty routes) and outbound HTTPS access from PHP to Delta / AI providers.

## Install (XAMPP)
1. Extract this folder into `htdocs/btc-intelligence-platform`.
2. Create a MySQL database named `btc_intelligence` (or set your own `DB_NAME`). Migrations create tables, not the database itself.
3. Copy `.env.example` to `.env` and configure database credentials and `APP_URL`.
4. Verify `DELTA_BASE_URL` and `DELTA_SYMBOL` for your Delta account/product.
5. Open `http://localhost/btc-intelligence-platform/`. With `APP_AUTO_MIGRATE=true`, migrations run automatically at startup. Or run `php database/migrate.php` from the project directory.
6. Test `api.php?action=health`, then `api.php?action=ticker`, `api.php?action=candles`, `api.php?action=orderbook`.

## Configuration
All settings are read server-side from `.env` and mapped to constants in `app/bootstrap.php`.
- `DELTA_BASE_URL`, `DELTA_SYMBOL`, `DELTA_CANDLE_RESOLUTION`, `DELTA_HTTP_TIMEOUT`: public Delta data.
- `CHATGPT_API_KEY`, `CHATGPT_MODEL`: optional OpenAI analysis.
- `GEMINI_API_KEY`, `GEMINI_MODEL`: optional Gemini analysis.
- `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_CHARSET`: MySQL.
- `APP_ENV`, `APP_DEBUG`, `APP_AUTO_MIGRATE`, `APP_URL`, `APP_TIMEZONE`: runtime.
- `DEFAULT_CAPITAL`, `DEFAULT_RISK_PERCENT`, `MAX_RISK_PERCENT`, `MAX_DAILY_LOSS_PERCENT`: risk defaults.
- `DELTA_API_KEY` / `DELTA_API_SECRET` are reserved but not used; private endpoints and trading permissions are not implemented.

## Included
- Responsive dark market dashboard, live ticker/candles/orderbook/trades via Delta REST API, stale/unavailable states.
- Lightweight Charts candlestick view and multi-timeframe selector.
- EMA/RSI/ATR-style calculations, order-book depth imbalance, trade flow when exchange side data is present.
- Rule-based assessment that defaults to WAIT.
- Risk calculator with server-side validation and explicit contract-specific caveats.
- MySQL paper-plan journal and automatic idempotent migrations.
- Optional server-side ChatGPT / Gemini explanation using a fresh market snapshot.
- `.htaccess` source/config protection and optional `/api/*` routes.

## API routes
`GET api.php?action=health|ticker|candles&resolution=15m&limit=200|orderbook|trades|analysis`
`POST api.php?action=calculate-risk` JSON risk inputs
`POST api.php?action=paper-trade` JSON `{ "plan": { ...risk inputs... }, "note": "..." }`
`GET api.php?action=paper-trades`
`POST api.php?action=ai-analysis` JSON `{ "provider":"openai"|"gemini", "question":"..." }`

## AI
Set `CHATGPT_API_KEY` and/or `GEMINI_API_KEY` in `.env`. Keys are only used by PHP; the browser never receives them. AI interprets a timestamped snapshot and cannot override risk validation. If no key is configured, the dashboard and market data still work.

## Notes / limitations
- Dashboard polls REST endpoints; it does not claim a WebSocket is connected. Data freshness and endpoint errors are shown.
- Delta API response formats may change; check official docs and adapt `app/Services/DeltaClient.php` if needed: https://docs.delta.exchange/.
- Risk sizing is a linear price-distance estimate. Inverse/quanto contracts may use different P&L maths. Verify contract specs before using any result.
- “Anywhere” depends on hosting. `.htaccess` requires Apache and `AllowOverride All`; Nginx/IIS need equivalent server rules. The direct `api.php?action=...` routes work without rewrite.
- Before deployment: `APP_ENV=production`, `APP_DEBUG=false`, HTTPS, least-privilege DB account, backups, keep `.env` private, and review all configuration.
