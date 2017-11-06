# External ID Keeper

This CiviCRM extension prevents deletion of contacts that have external ID values.

## How it works

* The standard *"CiviCRM: delete contacts"* permission is changed so that users cannot delete contacts that have external ID values.

* A new permission *"CiviCRM External ID Keeper: delete contacts with external ID values"* is added to allow administrators to delete all contacts.

## Setup

1. Install this extension.
1. For users who should not be able to delete any contacts:
    1. Revoke the following permissions:
        * *"CiviCRM: delete contacts"*
        * *"CiviCRM External ID Keeper: delete contacts with external ID values"*
1. For users who should only be able to delete contacts that don't have external ID values:
    1. Grant the *"CiviCRM: delete contacts"* permission.
    1. Revoke the *"CiviCRM External ID Keeper: delete contacts without external ID values"* permission.
1. For users who should be able to delete all contacts, even if they have external ID values:
    1. Grant the following permissions:
        * *"CiviCRM: delete contacts"*
        * *"CiviCRM External ID Keeper: delete contacts with external ID values"*
