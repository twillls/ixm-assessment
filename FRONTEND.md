# Frontend Tools

Install the tools by running the `swat frontend:setup` or `swat theme:setup`
command. The default Bootstrap theme includes an example global theme and
component example. Happy building!

## Standards & Formatting

Included are the recommended code standards and formatting for JavaScript,
Sass/CSS, and Yaml. All projects should be using these standards for development
and production builds. Code standards are comprised of Airbnb, Node Security,
Drupal, and custom rules. Formatting is controlled by Prettier across all
supported languages.

> **⚠️ IMPORTANT** - Modifying or disabling rules is allowed, but strongly
> discouraged. The default rules attempt to cover most use cases for consistency
> and reliability. Please reach out to discuss changes that could potentially be
> added to the default rules.

Use any of the following commands to validate the codebase. To autofix issues,
when possible, add `:fix` at the end of the command. When building deployment
artifacts the `swat validate:frontend` command should be used instead.

```shell
yarn lint
yarn lint:yaml
yarn lint:js
yarn lint:style
```

## Package Builds

Projects using Docksal for local development may use the following commands to
start a build within the container. When building deployment artifacts
the `swat frontend:build` command should be used instead.

```shell
# Build all packages.
fin frontend/build
# Build single package.
fin frontend/build @theme/component.example
```

Builds may also be initiated directly with the Yarn scripts provided in the
default `package.json` configuration. Usually these scripts can run locally,
outside of a container, with improved performance. If running locally is causing
issues, add `fin exec` at the start of the command to run it inside the
container.

```shell
# Build all packages.
yarn build
# Build all packages, ignoring local disk cache.
yarn build --force
# Build single package.
yarn build:scope @theme/component.example
# Build all packages in production mode.
yarn build:production
# Build and watch for changes in single package.
yarn watch @theme/component.example
```

## Package & Component Structure

All packages must adhere to the established monorepo structure to properly use
these frontend tools. There are no limitations to the number of packages a
project may contain. That said, keep in mind that each new package could add to
the overall build time.

### Monorepo structure

```shell
┌── components/
│   │
│   └── example-component/
│       │ # Static assets including but not limited to images, videos, and web fonts.
│       ├── assets/
│       │
│       │ # Public build output.
│       ├── public/
│       │   └── assets/ js/ css/
│       │
│       │ # Source code used to build public output.
│       ├── src/
│       │   ├── icons/
│       │   │   │ # Vector images to create an icons sprite.
│       │   │   └── *.svg
│       │   ├── images/
│       │   │   │ # Vector images to optimize.
│       │   │   └── *.svg
│       │   ├── js/
│       │   │   │ # JavaScript written in ES6.
│       │   │   └── *.js
│       │   ├── scss/
│       │   │   │ # Styles written in Sass.
│       │   │   └── *.scss
│       │   │
│       │   │ # Build entry point.
│       │   └── index.js
│       │
│       │ # Mandatory package definition.
│       ├── package.json
│       │ # Optional webpack configuration overrides.
│       └── webpack.config.js
│
├── example.info.yml
└── example.libraries.yml
```

An entry point tells Webpack how it should build the packages public output.
Here's an example `src/index.js` entry point that generates CSS, imports an
arbitrary example library, and defines a Drupal behavior.

```js
import "./scss/styles.scss";
import ExampleLibrary from "example-library";

((Drupal) => {
  Drupal.behaviors.exampleComponent = {
    ...
  };
})(Drupal);
```

### Package definition

At minimum, each `package.json` definition must include the following
configuration. Name needs to be unique to the codebase and is also referred to
as workspace when using Yarn commands. The `build` script allows Yarn scripts to
run webpack builds in any of the defined workspaces. Modfying the script could
cause unexpected behaviors or build errors.

> **⚠️ IMPORTANT** - Package dependencies should be added to the workspace
> instead of the project root. See [Workspaces](#workspaces) for more
> information on using Yarn to manage dependencies and perform other workspace
> related operations.

```json
{
  "name": "@{module,theme}/{package_name}",
  "private": true,
  "version": "0.0.0",
  "scripts": { "build": "webpack" }
}
```

Although package name formatting is not strictly enforced, it's recommended to
adhere to the following nomenclature.

- Theme: `@theme/global`
- Theme component: `@theme/component.{component_name}`
- Module: `@module/{module_name}`
- Module component: `@module/{module_name}.{component_name}`

## Build Technology

Packages are built using [Turborepo](https://turbo.build/)
and [Webpack](https://webpack.js.org/). The project root `webpack.config.js`
attempts to cover most use cases. Including a Sass, JavaScript, and SVG compiler
out of the box. Adhering to the [[Frontend Tools#Monorepo structure]] ensures
the default compilers are made available without the need to create webpack
configurations in each package. In some cases it may be necessary to extend the
project root configuration by adding `webpack.config.js` to the custom package
folder in the following format.

```js
module.exports = (env, argv, config, directory) => {
  // Add, modify, or remove configurations for this package only.
  return config;
};
```

## Tips & Tricks

### Imports

Each custom package can be imported to another custom package in both JavaScript
and Sass. For example, import theme scaffolding into a component
with `@import '@theme/global/src/scss/abstracts/scaffold';` at the top of the
Sass file.

### Workspaces

Yarn workspaces allow custom packages to be managed from the project root. For
example, `yarn workspace @theme/global add -D react` adds a react dependency to
the global theme. See https://yarnpkg.com/features/workspaces for more examples.

### Icons

Vector icons placed in the `src/icons/` folder are compiled into a single
sprite. Use the provided `icon.html.twig` template to insert icons into a page.
Be sure to replace `{theme_name}` with the Drupal theme name and `{icon_name}`
with the icon filename.

```twig
{% include '@{theme_name}/components/icon.html.twig' with {'name': '{icon_name}', 'classes': ['icon-sm']} %}
```
