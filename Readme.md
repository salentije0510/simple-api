# Frontify Color API

Hello there! 👋

The intention of this little api server is **creating, reading, updating and deleting colors**. Most of it is missing
still. Show us your coding style and how well and proper you can engineer solutions for even simple problems. Do it as
well as you would expect for a code review by yourself. Don't spend too much time though – _perfect is the enemy of
good_ after all.

## Installation, Test & Execution

**Requirements:** PHP 7.3+, node.js (optional, format the code manually if you can't use Prettier).

We use [http-server-request](https://github.com/sunrise-php/http-server-request) to abstract PHP's `$_SERVER`
and `$_REQUEST` superglobals, [Prettier for PHP](https://github.com/prettier/plugin-php) for code-formatting
and [PHPUnit](https://phpunit.de/) for testing:

```shell
npm i && php composer.phar install
```

Run the built-in server available at [localhost:8080](http://localhost:8080):

```shell
npm start
```

Execute the PHPUnit tests via NPM shortcut:

```shell
npm test
```

## Your Task

- Implement CRUD operations for colors. A color should have a name and the color value.
- Add standard behavior one can expect of a RESTful API.
- Use Sqlite for persistence.
- Make simple, elegant software.
- Provide production-ready code quality.

## Rules Of The Game

- Don't use any further library or framework.
- The code must be your own—no code generators or assistants allowed (e.g. GitHub Copilot).
- Feel free to change existing code (or fix existing problems) as you see fit.
- Don't share the code publicly but just send it back to us.
- **Enjoy!**
