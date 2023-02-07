### IDC Code challenge

1) Fork repository
2) Open a new branch
3) Complete all requirements
4) Make a pull request
5) Send link on your pull request

### Set up

1) Clone project
2) Build and run all existing docker containers
3) Enter the back-end container or locally to install all dependencies with composer
4) Execute migrations and fixtures
5) Run the front-end locally `npm run dev`

Open [the link](http://localhost:5173/)

Simple todo list where you can add, update or delete Todo
Please open `/login` page and see the form where you can sign in as test user

Use these credentials:
  - Email: `test@test.com`
  - Password: `123456`

After authorization, you will see the todo list belonging to the logged-in user

### Docker requirements

1) Improve `backend/Dockerfile` with composer installation and adding xdebug
2) Front-end must run in a docker container as well (use docker-composer.yaml file and frontend/Dockerfile)
3) Make pull request to your repository and let us know

### Backend requirements

1) Code refactoring
2) Write unit test with phpunit library for creating, updating and deleting a todo
3) **Not required!** using php code sniffer and psaml
4) Make pull request to your repository and let us know

### Front-end requirements

1) Fix code style with eslint, prettier and stylelint
2) Code refactoring
3) Protect todo routes where unauthorized user should not see `/` (todo list page) and should be redirected to `/login` page
4) After refreshing the page, user must be authorized in if the user was previously logged in
5) Write unit tests for `Todo.vue` component(s) with mocha or jest or any other testing framework
6) Make pull request to your repository and let us know
