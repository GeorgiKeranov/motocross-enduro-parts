## Dependencies
1. Use Node 12 LTS for this theme. The build toolchain is legacy and is not compatible with Node 24.
2. Latest version of one of the following package managers

- [NPM](https://www.npmjs.com/) (min v5.3.0)
- [Yarn](https://yarnpkg.com/) (min v0.20.4)

## Install
Use a compatible Node version first, then install dependencies in the root directory of the project:

```
nvm install 12.22.12
nvm use 12.22.12
yarn install
```

or

```
nvm install 12.22.12
nvm use 12.22.12
npm install
```

## Development
To start the project in development mode, run:

```
npm run dev
```

This command starts a [browsersync](https://browsersync.io/) server, serves the projects assets and opens your default browser. 

## Build
To build the project, run:

```
npm run build
```

This command will generate an images sprite and build all assets(html, css and javascript) in the `dist` folder. Assets live in the `resources` folder. 

## Configuration files
The build process configuration files live in `resources/build` directory. 

