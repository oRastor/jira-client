# JIRA Client
A simple JIRA REST client for PHP.

The main or killing feature of this library is resolving custom fields of issues.

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/f2cdc120e5cc47018790e84e9e7330e0)](https://www.codacy.com/app/doom4eg/jira-client?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=oRastor/jira-client&amp;utm_campaign=Badge_Grade)

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

    // Get an array of transitions for issue
    $transitions = $api->issue()->getTransitions($newIssue->getKey());

    // Executing transitions to change issue status
    $newIssue->transition()->execute(120);
    
    // Searches for issues using JQL
    $issues = new JiraClient\Request\SearchIterator($api, "project = Test");

    // or another way
    $issues = $api->issue()->search("project = Test");

    // Total count of found issues
    $total = $issues->getTotal();

    foreach ($issues as $issue) {
        $issue->update()
            ->fieldAdd(Field::LABELS, 'new-label')
            ->execute();
    }
} catch (\JiraClient\Exception\JiraException $e) {
    // exception processing
}

```

## Installation

```sh
composer require "rastor/jira-client:~0.4"
```
