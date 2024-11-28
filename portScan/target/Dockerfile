FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteractive

# 必要なリポジトリとパッケージの追加
RUN apt-get update && apt-get install -y \
    software-properties-common \
    wget \
    gnupg \
    && rm -rf /var/lib/apt/lists/*

# Suricataの公式リポジトリを追加
RUN add-apt-repository ppa:oisf/suricata-stable

# パッケージのインストール
RUN apt-get update && apt-get install -y \
    openssh-server \
    apache2 \
    tshark \
    suricata \
    vim \
    curl \
    && rm -rf /var/lib/apt/lists/*

# SSHサーバーの設定
RUN mkdir /var/run/sshd
RUN echo 'root:password' | chpasswd
RUN sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config

# Apache2の設定
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# wiresharkを非rootユーザーで実行できるようにする
RUN groupadd wireshark
RUN usermod -aG wireshark root
RUN chgrp wireshark /usr/bin/dumpcap
RUN chmod 750 /usr/bin/dumpcap
RUN setcap cap_net_raw,cap_net_admin=eip /usr/bin/dumpcap

# suricata-update
RUN suricata-update

# 起動スクリプト
COPY start-services.sh /start-services.sh
RUN chmod +x /start-services.sh

CMD ["/start-services.sh"]