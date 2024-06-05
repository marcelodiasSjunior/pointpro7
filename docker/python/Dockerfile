FROM python:3.9
WORKDIR "/app"

ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

RUN apt-get update -y && \
    apt-get install -yq git supervisor zlib1g-dev python3-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev

RUN apt-get install -y build-essential cmake libopenblas-dev liblapack-dev pkg-config libx11-dev libatlas-base-dev libgtk-3-dev libboost-python-dev

COPY requirements.txt requirements.txt
RUN python --version
RUN pip install dlib
RUN pip install -r requirements.txt

CMD ["python", "api.py"]