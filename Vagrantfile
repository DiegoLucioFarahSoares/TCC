# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.box = "ubuntu/focal64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  # config.vm.network "forwarded_port", guest: 80, host: 80

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.33.10"


  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder ".", "/var/www/html"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  config.vm.provider "virtualbox" do |vb|
     # Display the VirtualBox GUI when booting the machine
     # vb.gui = true

     # Customize the amount of memory on the VM:
     vb.memory = "5000"
     vb.name = "srv-apache-sic"
     vb.customize ["modifyvm", :id, "--groups", "/SIC"]
   end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Ansible, Chef, Docker, Puppet and Salt are also available. Please see the
  # documentation for more information about their specific syntax and use.
  config.vm.provision "shell", inline: <<-SHELL

    apt-get update

    if [ ! -e "/etc/apache2/sites-available/000-default.conf.bak" ]; then

        apt-get install -y apache2
        apt-get install -y php libapache2-mod-php
        apt-get install -y composer
        apt-get install -y php-curl
        apt-get install -y php-soapi
        apt-get install -y php-xdebug
        apt-get install -y php-mysql
        apt-get install -y php-pdo
        apt-get install -y php-xml

        cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf.bak
        cp /var/www/html/log-apache/000-default.conf /etc/apache2/sites-available

        ln -s /var/www/html /home/vagrant/sic

        a2enmod rewrite
    fi

    if [ ! -e "/etc/php/7.4/mods-available/xdebug.ini.bak" ]; then

        cp /etc/php/7.4/mods-available/xdebug.ini /etc/php/7.4/mods-available/xdebug.ini.bak

        echo "xdebug.show_error_trace=1" >> /etc/php/7.4/mods-available/xdebug.ini
    fi

    if [ ! -e "/etc/php/7.4/apache2/php.ini.bak" ]; then

        cp /etc/php/7.4/apache2/php.ini /etc/php/7.4/apache2/php.ini.bak

        echo ""                                 >> /etc/php/7.4/apache2/php.ini
        echo "xdebug.remote_enable=1"           >> /etc/php/7.4/apache2/php.ini
        echo "xdebug.remote_handler=dbgp"       >> /etc/php/7.4/apache2/php.ini
        echo "xdebug.remote_host=192.168.33.1"  >> /etc/php/7.4/apache2/php.ini
        echo "xdebug.remote_port=9000"          >> /etc/php/7.4/apache2/php.ini
    fi

    service apache2 restart
  SHELL
end
