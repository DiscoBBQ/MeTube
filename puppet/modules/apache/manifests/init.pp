class apache 
{      
    package 
    { 
        "apache2":
            ensure  => present,
            require => [Exec['apt-get update'], Package['php5'], Package['php5-dev'], Package['php5-cli']]
    }
    
    service 
    { 
        "apache2":
            ensure      => running,
            enable      => true,
            require     => [Package['apache2'], File["/etc/apache2/conf-enabled"]],
            subscribe   => [
                File["/etc/apache2/mods-enabled/rewrite.load"],
                File["/etc/apache2/sites-available/000-default.conf"],
                # File["/etc/apache2/conf-enabled/phpmyadmin.conf"]
            ],
    }

    file{
        "/etc/apache2/conf-enabled":
        ensure => "directory",
        owner => root, group => root,
        mode => '0775',
        require => Package['apache2'],
    }

    file 
    { 
        "/etc/apache2/mods-enabled/rewrite.load":
            ensure  => link,
            target  => "/etc/apache2/mods-available/rewrite.load",
            require => Package['apache2'],
    }

    file 
    { 
        "/etc/apache2/sites-available/000-default.conf":
            ensure  => file,
            owner => root, group => root,
            source  => "/vagrant/puppet/templates/vhost",
            require => Package['apache2'],
    }

    file{
        "/etc/apache2/sites-enabled/000-default":
        ensure => link,
        target => "/etc/apache2/sites-available/000-default.conf",
        require => File["/etc/apache2/sites-available/000-default.conf"]
    }

    exec{
        "sudo service apache2 restart":
        require => [
            File["/etc/apache2/sites-enabled/000-default"],
            service['apache2']
        ],
    }

    exec 
    { 
        'echo "ServerName localhost" | sudo tee /etc/apache2/conf-enabled/fqdn.conf':
            require => Package['apache2'],
    }
}
