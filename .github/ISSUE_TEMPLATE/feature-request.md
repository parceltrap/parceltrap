name: Feature Request
description: If you have a suggestion (and may want to implement it).
labels: [ 'type: discussion' ]

body:

- type: textarea
  id: description
  attributes:
  label: Description
  description: Explain the change or addition that you are proposing.
  validations:
  required: true

- type: textarea
  id: implementation
  attributes:
  label: Possible implementation
  description: Not obligatory, but suggest an idea for implementing addition or change.
  validations:
  required: true
