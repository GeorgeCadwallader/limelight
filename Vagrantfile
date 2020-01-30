# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "practically/web7.2"
  config.vm.box_url = "http://archive.stage.zportal.co.uk/vagrant/web7.2/metadata.json"
  config.vm.box_check_update = true
  config.vm.network "forwarded_port", guest: 80, host: 8888
  config.vm.network "forwarded_port", guest: 3000, host: 3000

  # Prevent TTY Errors (copied from laravel/homestead: "homestead.rb" file)... By default this is "bash -l".
  config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"
  config.vm.synced_folder ".", "/vagrant", :mount_options => ["dmode=777","fmode=777"]

  #config.trigger.after :up, :reload do |trigger|
    #trigger.run_remote = {inline: "vagrant-trigger-up"}
  #end
end

vagrantfile = "./Vagrantfile.local"
load File.expand_path(vagrantfile) if File.exists?(vagrantfile)
