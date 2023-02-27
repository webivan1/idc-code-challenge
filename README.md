### IDC Code challenge

1) Fork our repository
2) Open a new branch (for example dev)
3) Do code review
4) Make a pull request
5) Send link on your pull request

### Set up

1) Clone project
2) Build and run all existing docker containers
3) Generate public/private keys
    - `bin/console lexik:jwt:generate-keypair`
4) Execute migrations and fixtures
    - `bin/console doctrine:migrations:migrate`
    - `bin/console doctrine:fixtures:load -n --append`
5) Run the front-end locally `npm run dev`

Open [http://localhost:5173/login](http://localhost:5173/login)

Simple todo list where you can add, update or delete Todo
Please open `/login` page and see the form where you can sign in as test user

Use these credentials:
  - Email: `test@test.com`
  - Password: `123456`

What you will see:
- You can see the list of todo categories where you can select any category and see todo list belonging to selected category.
- You can remove existing todo (Need fix)
- You can change status of todo (Need fix)
- You can filter todo list by title
- You can add a new todo (Need fix)

### Do what you can do

#### Bugs and features

- You should not see categories page (url: /) if you aren't authorised
- You should not see any todo if you aren't authorised
- After authorisation JWT token must be stored somewhere (local, cookie or session storage)
- After refreshing the page you should be authorised if JWT token is stored and not expired otherwise redirect to /login page
- If user logged-in
  - You can see all categories (page: /) and total of todo list belonging logged-in user
  - You can see only own todo list
  - You can manage (add, update, delete) only own todo

#### Backend

- Code refactoring
- /api/* routes must be protected with jwt token
- Logged-in user must see only own todos 
- Excluding password of user from json response
- Validate requests
- Write unit tests with phpunit library for creating, updating and deleting a todo
- Use php code sniffer and psalm

*Make pull request to your repository and let us know*

#### Front-end

- Fix code style with eslint, prettier and stylelint
- Code refactoring
- Protect todo routes where unauthorized user should not see `/` (todo list page) and should be redirected to `/login` page
- After refreshing the page, user must be authorized in if the user was previously logged in
- Write unit tests for `Todo.vue` component(s) with mocha or jest or any other testing framework
- Make pull request to your repository and let us know

*Make pull request to your repository and let us know*

#### Docker

- Front-end must run in a docker container as well (use docker-composer.yml file and docker/nodejs/Dockerfile)
- Add Xdebug for PHP

*Make pull request to your repository and let us know*
