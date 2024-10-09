# helloworld_http

## Introduction

This is the example for GCP Cloud function with PHP.

## Deployment

- Clone this repository.
- Running the `compoer install` command to install required dependencies.
- Running the following command to deploy this function:

```sh
function_name="your function name"
REGION="your GCP region"

gcloud functions deploy ${function_name} \
    --gen2 \
    --runtime=php82 \
    --region="$REGION" \
    --source=. \
    --entry-point=helloHttp \
    --trigger-http \
    --allow-unauthenticated
```

- Running the following command to delete the function:

```sh
function_name="your function name"
REGION="your GCP region"

gcloud functions delete ${function_name} --region="$REGION"
```

## References

- https://cloud.google.com/functions/docs/create-deploy-http-php
- https://cloud.google.com/functions/docs/samples/functions-http-cors
