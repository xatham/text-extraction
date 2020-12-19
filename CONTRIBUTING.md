## Reporting a bug

To a report a bug, please consider using the github `issues` section.

Be as specific as possible when describing the issue.

## Coding standards

These coding standards are based on the `PSR-1`, `PSR-2` and `PSR-4` standards, so you may already know most of them.

### Naming Conventions

- Use camelCase for PHP variables, function and method names, arguments (e.g. $acceptableContentTypes, hasSession());
- Use snake_case for configuration parameters and Twig template variables (e.g. framework.csrf_protection, http_status_code);
- Use namespaces for all PHP classes and UpperCamelCase for their names (e.g. ConsoleLogger);
- Prefix all abstract classes with Abstract except PHPUnit *TestCase. Please note some early Symfony classes do not follow this convention and have not been renamed for backward compatibility reasons. However, all new abstract classes must follow this naming convention;
- Suffix interfaces with Interface;
- Suffix traits with Trait;
- Suffix exceptions with Exception;
- Use UpperCamelCase for naming PHP files (e.g. EnvVarProcessor.php) and snake case for naming Twig templates and web assets (section_layout.html.twig, index.scss);
- For type-hinting in PHPDocs and casting, use bool (instead of boolean or Boolean), int (instead of integer), float (instead of double or real);
- Don’t forget to look at the more verbose Conventions document for more subjective naming considerations.
