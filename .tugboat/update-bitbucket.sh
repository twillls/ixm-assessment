#!/bin/bash

################
# Do not edit.
################
STATUS=${1:-"INPROGRESS"}

if [ "$STATUS" != "INPROGRESS" ]; then
  case $STATUS in
    1)
      STATE="FAILED"
      DESCRIPTION="Something went wrong!"
      ;;
    0)
      STATE="SUCCESSFUL"
      DESCRIPTION="ALL TESTS PASSED!"
      ;;
    *)
      STATE="FAILED"
      DESCRIPTION="$STATUS tests failed!"
      ;;
  esac
else
  STATE=$STATUS
  DESCRIPTION="Tests are running"
fi

# There are variables that are only injected into Tugboat Previews that are built from a Bitbucket pull request.
# i.e.: $TUGBOAT_BITBUCKET_TITLE
# Gets the ticket number from another env var.
DASHBOARD="https://dashboard.tugboatqa.com/$TUGBOAT_PREVIEW_ID"
curl --location "https://api.bitbucket.org/2.0/repositories/ixm/$TUGBOAT_BITBUCKET_SLUG/commit/$TUGBOAT_PREVIEW_SHA/statuses/build" \
  --header 'Content-Type: application/json' \
  --header 'Accept: application/json' \
  --user "ixmdev:$BB_TOKEN" \
  --data '{
    "key": "TUGCYP",
    "url": "'"$DASHBOARD"'",
    "state": "'"$STATE"'",
    "name": "Cypress Tests",
    "description": "'"$DESCRIPTION"'"
  }'
