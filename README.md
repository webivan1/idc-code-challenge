### IDC Code challenge

1) Fork repository
2) Open a new branch
3) Complete all requirements
4) Make a pull request
5) Send link on your pull request

### Set up

1) Clone project
2) Build and run all existing docker containers
3) Generate public/private keys
    - `bin/console lexik:jwt:generate-keypair`
3) Execute migrations and fixtures
    - `bin/console doctrine:migrations:migrate`
    - `bin/console doctrine:fixtures:load -n --append`
4) Run the front-end locally `npm run dev`

Open [http://localhost:5173/login](http://localhost:5173/login)

Simple todo list where you can add, update or delete Todo
Please open `/login` page and see the form where you can sign in as test user

Use these credentials:
  - Email: `test@test.com`
  - Password: `123456`

After authorization, you will see the todo list belonging to the logged-in user

### Backend requirements

1) Code refactoring
2) Protect routes with guards
3) Write unit tests with phpunit library for creating, updating and deleting a todo
4) **Not required!** using php code sniffer and psaml
5) Make pull request to your repository and let us know

### Front-end requirements

1) Fix code style with eslint, prettier and stylelint
2) Code refactoring
3) Protect todo routes where unauthorized user should not see `/` (todo list page) and should be redirected to `/login` page
4) After refreshing the page, user must be authorized in if the user was previously logged in
5) Write unit tests for `Todo.vue` component(s) with mocha or jest or any other testing framework
6) Make pull request to your repository and let us know

### Docker requirements

1) Front-end must run in a docker container as well (use docker-composer.yml file and docker/nodejs/Dockerfile)
2) Add Xdebug for PHP
3) Make pull request to your repository and let us know
