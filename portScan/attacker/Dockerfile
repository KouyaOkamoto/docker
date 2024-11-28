FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    wireshark \
    nmap \
    hping3 \
    iputils-ping \
    openssh-client \
    curl \
    apache2 \
    && rm -rf /var/lib/apt/lists/*

#apache2の設定
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# wiresharkを非rootユーザーで実行できるようにする
RUN groupadd wireshark
RUN usermod -aG wireshark root

CMD ["/bin/bash"]