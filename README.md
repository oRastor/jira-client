# JIRA Client
A simple JIRA REST client for PHP.

## Example

```php
$api = new JiraClient\JiraClient('http://jira.hostname', 'login', 'password');

try {
    // Get an existing issue
    $issue = $api->issue()->get('JRA-123');

    // Print the issue id.
    echo $issue->getId();

    // Print the issue key.
    echo $issue->getKey();

    // Create new issue.
    $newIssue = $api->issue()
        ->create('JIRA', 'Suggestion')
        ->field(Field::SUMMARY, 'My Suggestion')
        ->field(Field::DESCRIPTION, 'Some description')
        ->execute();

    // Print the issue id.
    echo $newIssue->getId();

    $newIssue = $newIssue->update()
        ->field(Field::DESCRIPTION, 'Some new description')
        ->customField(10012, 'Value for custom field')
        ->fieldAdd(Field::LABELS, 'new-label')
        ->execute();

    // Print description of updated issue.
    echo $newIssue->getDescription();

    // Two ways for adding new comment.
    $newIssue->addComment("Some comment content");
    $api->issue()->addComment($newIssue->getKey(), "Another comment content");

    // Add new comment limited to the developer role.
    $newIssue->addComment("Only for developers", "role", "Developers");

    // Get reporter's name.
    $reporterName = $newIssue->getReporter()->getName();

    // Get an array of labels.
    $labels = $newIssue->getLabels();

} catch (\JiraClient\Exception\JiraException $e) {
    // exception processing
}

```

## Installation

```sh
composer require "rastor/jira-client:0.3"
```
