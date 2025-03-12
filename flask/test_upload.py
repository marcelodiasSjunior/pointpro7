import boto3
from botocore.exceptions import ClientError

S3_ENDPOINT = "https://nyc3.digitaloceanspaces.com/"
S3_KEY = "DO00NQZBZRM97738PRRK"
S3_SECRET = "MHvrodg1KgvqhaZE9o1FpvQ9hnP1miAz4EBVobuJwb4"
S3_BUCKET = "pro7"
S3_REGION = "nyc3"

s3 = boto3.client(
    's3',
    endpoint_url=S3_ENDPOINT,
    aws_access_key_id=S3_KEY,
    aws_secret_access_key=S3_SECRET,
    region_name=S3_REGION
)

try:
    s3.upload_file("test.txt", S3_BUCKET, "test.txt", ExtraArgs={
        'ACL': 'public-read',
        'ContentType': 'text/plain'
    })
    print("Upload realizado com sucesso.")
except ClientError as e:
    print("Erro no upload:", e)
