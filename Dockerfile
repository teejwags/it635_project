FROM centos:7
RUN yum update -y && yum install httpd php php-mysql -y
EXPOSE 80
ENTRYPOINT ["/usr/sbin/httpd", "-D", "FOREGROUND"]
