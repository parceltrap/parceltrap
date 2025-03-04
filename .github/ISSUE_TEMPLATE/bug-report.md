name: Bug Report
description: If something isn't working as expected.
labels: [ 'type: bug' ]

body:

- type: markdown
  attributes:
  value: |
  Thanks for taking the time to fill out this bug report!

- type: textarea
  id: description
  attributes:
  label: What happened?
  description: Also tell us, what did you expect to happen?
  validations:
  required: true

- type: input
  id: library-version
  attributes:
  label: Library version
  description: What version of the library are you using? Please be as specific as possible.
  validations:
  required: true

- type: input
  id: php-version
  attributes:
  label: PHP version
  description: What version of PHP are you using? Please be as specific as possible.
  placeholder: 8.2.0
  validations:
  required: true

- type: dropdown
  id: operating-system
  attributes:
  label: What operating systems are you seeing the problem on?
  multiple: true
  options:
  - macOS
  - Linux
  - Windows
  validations:
  required: true

- type: textarea
  id: notes
  attributes:
  label: Notes
  description: Use this field to provide any other notes that you feel might be relevant to the issue.
