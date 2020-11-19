## Dependencies
1. Latest version of [NodeJS](http://nodejs.org/) (min v6.0.0)
2. Latest version of one of the following package managers

- [NPM](https://www.npmjs.com/) (min v5.3.0)
- [Yarn](https://yarnpkg.com/) (min v0.20.4)

## Install
In the root directory of the project run:

```
npm install
```

or

```
yarn install
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

