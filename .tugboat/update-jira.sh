#!/bin/bash

#### Config ####

# JIRA PROJECT PREFIX. i.e. ONSC0381
PREFIX=''

################
# Do not edit.
################
REGEX_TICKET="(${PREFIX}-[0-9]+)"

# There are variables that are only injected into Tugboat Previews that are built from a Bitbucket pull request.
# i.e.: $TUGBOAT_BITBUCKET_TITLE
# Gets the ticket number from another env var.
TUGBOAT_BITBUCKET_TITLE=${TUGBOAT_BITBUCKET_TITLE:=$TUGBOAT_PREVIEW}

if [[ $TUGBOAT_BITBUCKET_TITLE =~ $REGEX_TICKET ]]; then
  TICKET=${BASH_REMATCH[1]}
  echo $TICKET
  DASHBOARD="https://dashboard.tugboatqa.com/$TUGBOAT_PREVIEW_ID"
  curl -v -X PUT https://imagex.atlassian.net/rest/api/3/issue/$TICKET \
    --user "$JIRA_USERNAME:$JIRA_TOKEN" \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json' \
    --data '{
      "fields": {
        "customfield_12769": "'"$TUGBOAT_DEFAULT_SERVICE_URL"'",
        "customfield_12770": "'"$DASHBOARD"'"
      }
    }'
else
  echo "Could not find associated ticket."
fi
