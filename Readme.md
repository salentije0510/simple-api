# Frontify Color API

Hello there! 👋

The goal of this task is to show us how you code and have a basis for discussion. This is no test, and it's okay if you 
implement just some parts. Give us enough to see where you stand as a developer, what your values are, and how your 
style is.

For this purpose, create a simple RESTful API for creating, reading, updating, and deleting operations on a Color 
entity. Pick a few operations to show a small workflow. Work on top of the existing skeleton and Git history. For the 
features you implement, show how well and proper you engineer solutions, even for simple problems. Do it as well as you 
would expect for a code review by yourself.

Keep in mind, we need a basis for discussion, not a fully-fledged enterprise solution. Thus, keep an eye on the time you 
spend.

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

- Implement some create, read, update, delete operations for the Color entity. A Color should have a name and a hex 
  color value.
- Add standard behavior one can expect of a RESTful API.
- Feel free to use any RDBMS.
- Provide production-ready code quality (like when you ship code for customers).
- Make simple, elegant software that you can explain and elaborate well during the follow-up discussion.

## Rules of the Game

- Don't use any further library or framework.
- You have to write your code — no code generators or assistants allowed (e.g., GitHub Copilot).
- Feel free to change existing code (or fix existing problems) as you see fit.
- Don't share the code publicly, just send it back to us.
- **Enjoy!**
