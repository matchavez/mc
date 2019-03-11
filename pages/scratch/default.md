---
title: scratch
---

# Instructions for Initial Creation of Azure Managed MySQL Database

## Overview

These instructions are for the CIP `TSOC_CIP_2019xx_000-Initial_MySQL_creation.docx` document.

A Azure Managed MySQL Database will be created in the `shared` zone of each environment thus this CIP need only applied once per environment (dev and ops subscriptions).  Updates to the development subscription (Metron141) will affect `dev01`, `tst01`, and `shd01`.  Updates to the production subscription (OpenMSS-Production)  will affect `ppd01`, `prd01`, and `prd02`.

## Table of Contents

1. [Preparation Steps](#Preparation-Steps)
1. [Pre-Implementation Steps and Testing](#Pre-Implementation-Steps-and-Testing)
1. [Implementation Steps](#Implementation-Steps)
1. [Post Implementation Testing](#Post-Implementation-Testing)
    1. [Post Implementation Change Success Verification](#Post-Implementation-Change-Success-Verification)
    1. [Post Implementation Product, Application, Infrastructure Verification](#Post-Implementation-Product,-Application,-Infrastructure-Verification)
1. [Service Assurance Operations Post Verification](#Service-Assurance-Operations-Post-Verification)
1. [Back out and Fix on Fail Procedure](#Back-out-and-Fix-on-Fail-Procedure)
1. [Post Implementation Monitoring](#Post-Implementation-Monitoring)
1. [Closure - Within 7 Days of Change Completion](#Closure---Within-7-Days-of-Change-Completion)

## CIP Instructions

### Preparation Steps

1. Ensure the secrets have been updated from their initial developer created values.

    This is a one time operation only, the details can be found [here](./Updating_Secrets.md)

### Pre-Implementation Steps and Testing

1. Connect to the Azure build host of the target environment

    As the actions occur at the Azure resource level only a single machine is required when running playbooks against the `dev` and `ops` subscriptions.

    The `deltaops-jmp01.australiaeast.cloudapp.azure.com` host (IP: 20.188.210.28; User: gsoc) is acceptable choice.

    ```bash
    $ hostname
    deltaops-jmp01.australiaeast.cloudapp.azure.com
    ```

1. Verify necessary Ansible and Azure tooling are in place

    1. Check the Azure CLI tool `az` is installed

        The following is a successful output, your version numbers may not match exactly to what is below.  The `azure-cli` command should be at the 2.0.59 level or greater.

        ```bash
        $ az --version
        azure-cli                         2.0.59

        acr                                2.2.1
        ...
        vm                                2.2.16

        Python location '/usr/lib64/az/bin/python'
        Extensions directory '/home/gsoc/.azure/cliextensions'

        Python (Linux) 2.7.5 (default, Oct 30 2018, 23:45:53)
        [GCC 4.8.5 20150623 (Red Hat 4.8.5-36)]

        Legal docs and information: aka.ms/AzureCliLegal

        Your CLI is up-to-date.
        ```

        The following is unsuccessful output

        ```bash
        $ az --version
        -bash: az: command not found
        ```

    1. Installing the Azure CLI tool `az`

        This step is only required when the above check produces unsuccessful output

        Ensure Internet access

        ```bash
        export https_proxy=https://10.200.40.6:3128
        export all_proxy=https://10.200.40.6:3128
        ```

        Yum repository setup\
        The following sets up the environment to be able to install additional YUM repository packages

        ```bash
        sudo -E rpm --import https://packages.microsoft.com/keys/microsoft.asc
        sudo sh -c 'echo -e "[azure-cli]\nname=Azure CLI\nbaseurl=https://packages.microsoft.com/yumrepos/
        azure-cli\nenabled=1\ngpgcheck=1\ngpgkey=https://packages.microsoft.com/keys/microsoft.asc" > /etc/yum.repos.d/azure-cli.repo'
        sudo -E yum install -y epel-release
        ```

        Yum package installation

        ```bash
        sudo -E yum update
        sudo -E yum install -y azure-cli python-pip
        ```

    1. Verify that the Ansible Azure python modules have been installed

        The follow is successful output, version numbers may differ

        ```bash
        $ pip list | grep azure
        DEPRECATION: The default format will switch to columns in the future. You can use --format=(legacy|columns) (or define a format=(legacy|columns) in your pip.conf under the [list] section) to disable this warning.
        azure (4.0.0)
        ...
        azure-mgmt (4.0.0)
        ...
        azure-storage-queue (1.4.0)
        msrestazure (0.6.0)
        ```

        The follow is unsuccessful output, version numbers may differ

        ```bash
        $ pip list | grep azure
        You are using pip version 8.1.2, however version 19.0.3 is available.
        You should consider upgrading via the 'pip install --upgrade pip' command.
        ```

        The warning about the pip version being old and a new version being available can be ignored.

    1. Installing the Ansible Azure python modules, if the above check was unsuccessful

        ```bash
        sudo -E pip install ansible azure ansible[azure] msrestazure packaging jmespath
        ```

1. Become the gsoc user if necessary, and setup a clean Ansible environment

    The following instructions the output value will change depending on which subscription is being used.
    The `XXX` literal below will be either `dev` (for development in the Metron141 subscription) or `ops` (for production in the OpenMSS-Production subscription)

    ```bash
    $ sudo su - gsoc
    Last login: .....

    [gsoc@shd01-jmp01 ~]$
    $ [[ -d ~/CIP_managed_mysql ]] && rm -rf ~/CIP_managed_mysql
    [gsoc@shd01-jmp01 ~]$
    $ mkdir ~/CIP_managed_mysql
    [gsoc@shd01-jmp01 ~]$

    $ cd ~/CIP_managed_mysql
    [gsoc@shd01-jmp01 CIP_managed_mysql]$
    ```

1. Setup `platform-services` repository as per following instructions

    1. The part of the following instructions that refer to `{supply tag name here}` please use `tags/MySQL_v1`, also replace the repository name of `platform-os-build` with `platform-services`

        Instructions provided via the following link:
        [Ansible workspace setup](https://tsoc.visualstudio.com/OpenMSS/_wiki/wikis/Product.wiki?wikiVersion=GBwikiMaster&pagePath=%2FPlatform%20documentation%2FAnsible%20workspace%20setup)

    1. Obtain the vault key from lastpass for the appropriate environment

        Edit the following file `~/CIP_managed_mysql/platform-services/.ansible_vault` and save the 128 hexadecimal character key.

### Implementation Steps

The following assumes that the above [Pre-Implementation Steps and Testing](#Pre-Implementation-Steps-and-Testing) steps have been performed within the same terminal session.  If this is not the case, then connect to the jump host, change user to gsoc.

1. Authenticate the Azure CLI / Ansible Azure tooling to the desired Azure subscription

    ```bash
    [gsoc@shd01-jmp01 ~]$ ~/CIP_managed_mysql/platform-services
    [gsoc@shd01-jmp01 platform-services]$ az login --use-device-code
    To sign in, use a web browser to open the page https://microsoft.com/devicelogin and enter the code XXXXXXXXX to authenticate.
    ```

    On a browser that is able to authenticate to Telstra, enter the above URL and enter the code as appropriate.

    On the build host

    For __development__ please use the following commands

    ```bash
    [gsoc@shd01-jmp01 platform-services]$ az account set --subscription=Metron141
    [gsoc@shd01-jmp01 platform-services]$ az account show
    {
        "environmentName": "AzureCloud",
        "id": "ea2be1e7-09f5-4737-bc57-8f7517c5aae6",
        "isDefault": true,
        "name": "Metron141",
        "state": "Enabled",
        "tenantId": "49dfc6a3-5fb7-49f4-adea-c54e725bb854",
        "user": {
            "name": "Martyn.Leadley@team.telstra.com",
            "type": "user"
        }
    }
    ```

    Key points to check for are `"isDefault": true` and `"name": "Metron141"`, the "user.name" will be the person that signed in

    For __production__ please use the following commands

    ```bash
    [gsoc@shd01-jmp01 platform-services]$ az account set --subscription=OpenMSS-Production
    [gsoc@shd01-jmp01 platform-services]$ az account show
    {
        "environmentName": "AzureCloud",
        "id": "6ac0d011-a7f0-49a7-9811-9355f83357a0",
        "isDefault": true,
        "name": "OpenMSS-Production",
        "state": "Enabled",
        "tenantId": "49dfc6a3-5fb7-49f4-adea-c54e725bb854",
        "user": {
            "name": "Martyn.Leadley@team.telstra.com",
            "type": "user"
        }
    }
    ```

    Key points to check for are `"isDefault": true` and `"name": "OpenMSS-Production"`, the "user.name" will be the person that signed in

1. Manual steps to update Azure Network Security Group rules, applied to each subnet that an Azure Managed MySQL Instance will attach to via VNet Rules

    Overview of required changes can be found on the [Network configuration](https://tsoc.visualstudio.com/OpenMSS/_wiki/wikis/Product.wiki?wikiVersion=GBwikiMaster&pagePath=%2FPlatform%20documentation%2FAzure%20MySQL%20setup%20and%20migration%2FNetwork%20configuration&pageId=881) wiki page.  These instructions are based of the information provided on the above page.

    For __development__ please use the following commands

    1. Sign on to the the [Azure Portal](https://portal.azure.com) if required

    1. Select `Subscriptions` in the side bar, and then select the "`Metron141`" subscription

    1. Enter `nsg` in the header search box, select "Network Security Group" under services

    1. There are multiple NSGs that need to be updated, this table provides the NSG name, and Source IP addresses to use in the following instructions

        | NSG Name | Source IP address values
        | --- | ---
        | dev_nsg_dev01_env-dev01_edge_10.200.128.0-24 | 10.200.128.10,10.200.128.11
        | dev_nsg_tst01_env-tst01_edge_10.200.144.0-24 | 10.200.144.10,10.200.144.11
        | dev_nsg_shd01_ss-intl_services_10.200.57.0-24 | 10.200.57.4,10.200.57.10
        | dev_nsg_shd01_acc-con_remote-access_10.200.32.0-24 | 10.200.32.4,10.200.32.5

    1. Using an entry in the above table, select NSG name i.e. `dev_nsg_dev01_env-dev01_edge_10.200.128.0-24` from the list of names.

    1. Click "Outbound security rules" from the "Network security group" menu

    1. Click "Add" button, and enter the following details in the "Add outbound security rule" dialog

        | Field Name | value to enter or select from drop down |
        | --- | --- |
        | Source | IP Address |
        | Source IP address/CIDR ranges | `10.200.128.10,10.200.128.11` |
        | Source Port | * |
        | Destination | Service Tag |
        | Destination service tag | Sql.AustraliaSoutheast |
        | Destination port ranges | 3306 |
        | Protocol | TCP |
        | Action | Allow |
        | Priority | 600 |
        | Name | AllowMySQL_Outbound |

        Click "Add" button on "Add outbound security rule" dialog

    For __production__ please use the following commands

    1. Sign on to the the [Azure Portal](https://portal.azure.com) if required

    1. Select `Subscriptions` in the side bar, and then select the "`OpenMSS-Production`" subscription

    1. Enter `nsg` in the header search box, select "Network Security Group" under services

    1. There are multiple NSGs that need to be updated, this table provides the NSG name, and Source IP addresses to use in the following instructions

        | NSG Name | Source IP address values
        | --- | ---
        | ops_nsg_prd01_env-prd01_edge_10.100.128.0-24 | 10.100.128.10,10.100.128.11
        | ops_nsg_prd02_env-prd02_edge_10.100.144.0-24 | 10.100.144.10,10.100.144.11
        | ops_nsg_shd01_ss-intl_services_10.100.57.0-24 | 10.100.57.4,10.100.57.10
        | ops_nsg_shd01_acc-con_remote-access_10.100.32.0-24 | 10.100.32.4,10.100.32.5

    1. Using an entry in the above table, select NSG name i.e. `ops_nsg_prd01_env-prd01_edge_10.100.128.0-24` from the list of names.

    1. Click "Outbound security rules" from the "Network security group" menu

    1. Click "Add" button, and enter the following details in the "Add outbound security rule" dialog

        <!-- This is to work around bad Azure DevOps rendering -->
        | - | Field Name | value to enter or select from drop down |
        | --- | ---: | --- |
        | Source | IP Address |
        | Source IP address/CIDR ranges | 10.100.128.10,10.100.128.11 |
        | Source Port | * |
        | Destination | Service Tag |
        | Destination service tag | Sql.AustraliaEast |
        | Destination port ranges | 3306 |
        | Protocol | TCP |
        | Action | Allow |
        | Priority | 600 |
        | Name | AllowMySQL_Outbound |

        <!-- This is the correct markdown
        | Field Name | value to enter or select from drop down |
        | ---: | --- |
        | Source | IP Address |
        | Source IP address/CIDR ranges | 10.100.128.10,10.100.128.11 |
        | Source Port | * |
        | Destination | Service Tag |
        | Destination service tag | Sql.AustraliaEast |
        | Destination port ranges | 3306 |
        | Protocol | TCP |
        | Action | Allow |
        | Priority | 600 |
        | Name | AllowMySQL_Outbound |
        -->

        Click "Add" button on "Add outbound security rule" dialog

    1. On the "Network security group" (to the left of the "Outbound security group" blade), select next NSG entry in the list and repeat previous two commands

1. Manual steps to add a Azure ServiceEndpoint to the necessary subnet

    For __development__ please use the following commands

    1. Sign on to the the [Azure Portal](https://portal.azure.com) if required

    1. Select `Subscriptions` in the side bar, and then select the "`Metron141`" subscription

    1. Select `Resources` in the menu of the "Subscription" blade

    1. Enter `dev_vnt_net` in the "Filter by name" text box, this will limit output to a single "Virtual network"

    1. Select `Subnets` in the menu of the "Virtual network" blade

    1. Enter `database` in the "Search subnets" text box

    1. Select `dev_snet_shd01_ss-intl_database_10.200.60.0-24` entry

    1. In the "Subnet" blade, select the `Services endpoints` combo drop down, and ensure tht `Microsoft.Sql` service is checked

    1. Click `Save` button

    1. Wait until notifications report that `Saved subnet` for the "dev_snet_shd01_ss-intl_database_10.200.60.0-24" subnet

    1. "Sign out" from the Azure Portal

    For __production__ please use the following commands

    1. Sign on to the the [Azure Portal](https://portal.azure.com) if required

    1. Select `Subscriptions` in the side bar, and then select the "`OpenMSS-Production`" subscription

    1. Select `Resources` in the menu of the "Subscription" blade

    1. Enter `dev_vnt_net` in the "Filter by name" text box, this will limit output to a single "Virtual network"

    1. Select `Subnets` in the menu of the "Virtual network" blade

    1. Enter `database` in the "Search subnets" text box

    1. Select `ops_snet_shd01_ss-intl_database_10.100.60.0-24` entry

    1. In the "Subnet" blade, select the `Services endpoints` combo drop down, and ensure tht `Microsoft.Sql` service is checked

    1. Click `Save` button

    1. Wait until notifications report that `Saved subnet` for the "ops_snet_shd01_ss-intl_database_10.100.60.0-24" subnet

    1. "Sign out" from the Azure Portal

    See [Network configuration](https://tsoc.visualstudio.com/OpenMSS/_wiki/wikis/Product.wiki?wikiVersion=GBwikiMaster&pagePath=%2FPlatform%20documentation%2FAzure%20MySQL%20setup%20and%20migration%2FNetwork%20configuration&pageId=881)

    and the Network configuration subsection that refers to "Connection security > add VNET Rules"

1. Run the ansible "database.yaml" playbook in `check` mode

    For __development__ please use the following commands

    ```bash
    $ cd ~/CIP_managed_mysql/platform-services/
    [gsoc@shd01-jmp01 platform-services]$
    $ ansible-playbook playbooks/database.yaml -e owner=dev -e selector_database="dev_shd01_adb" --check --diff
    PLAY [localhost] *************************************************************************************************

    ...

    TASK [database : Get Azure Resource Manager Facts on Microsoft.DBforMySQL 'dev_shd01_adb' | azure-mysql-create] ****************************************************************
    Friday 01 March 2019  10:04:02 +1300 (0:00:00.643)       0:00:02.755 **********
    [WARNING]: Azure API profile latest does not define an entry for GenericRestClient

    ok: [localhost]

    ...

    TASK [database : Create Azure Managed MySQL Database 'dev_shd01_adb' | azure-mysql-create] *************************************************************************************
    Friday 01 March 2019  10:04:03 +1300 (0:00:00.098)       0:00:04.106 **********
    skipping: [localhost]

    ...

    PLAY RECAP **********************************************************************************************
    localhost                  : ok=25   changed=1    unreachable=0    failed=0

    ...

    [gsoc@shd01-jmp01 platform-services]$
    ```

    Note: Key points to check for are

    ```text
    localhost                  : ok=25   changed=1    unreachable=0    failed=0
    ```

    For __production__ please use the following commands

    ```bash
    $ cd ~/CIP_managed_mysql/platform-services/
    [gsoc@shd01-jmp01 platform-services]$
    $ ansible-playbook playbooks/database.yaml -e owner=dev -e selector_database="ops_shd01_adb" --check --diff
    PLAY [localhost] *************************************************************************************************

    ...

    TASK [database : Get Azure Resource Manager Facts on Microsoft.DBforMySQL 'ops_shd01_adb' | azure-mysql-create] ****************************************************************
    Friday 01 March 2019  10:04:02 +1300 (0:00:00.643)       0:00:02.755 **********
    [WARNING]: Azure API profile latest does not define an entry for GenericRestClient

    ok: [localhost]

    ...

    TASK [database : Create Azure Managed MySQL Database 'ops_shd01_adb' | azure-mysql-create] *************************************************************************************
    Friday 01 March 2019  10:04:03 +1300 (0:00:00.098)       0:00:04.106 **********
    skipping: [localhost]

    ...

    PLAY RECAP **********************************************************************************************
    localhost                  : ok=25   changed=1    unreachable=0    failed=0

    ...

    [gsoc@shd01-jmp01 platform-services]$
    ```

    Note: Key points to check for are

    ```text
    localhost                  : ok=25   changed=1    unreachable=0    failed=0
    ```

1. Run the ansible "database.yaml" playbook to perform the requisite changes

    This step will create a Azure Managed MySQL Instance, plus associated action groups and alert metrics

    For __development__ please use the following commands

    ```bash
    $ cd ~/CIP_managed_mysql/platform-services/
    [gsoc@shd01-jmp01 platform-services]$
    $ ansible-playbook playbooks/database.yaml -e owner=dev -e selector_database="dev_shd01_adb"
    PLAY [localhost] ************************************************************************************************

    ...

    PLAY RECAP ******************************************************************************************************
    localhost                  : ok=5    changed=1    unreachable=0    failed=0
    [gsoc@shd01-jmp01 platform-services]$
    ```

    Note: Key points to check for are

    ```text
    localhost                  : ok=5    changed=1    unreachable=0    failed=0
    ```

    For __production__ please use the following commands

    ```bash
    $ cd ~/CIP_managed_mysql/platform-services/
    [gsoc@shd01-jmp01 platform-services]$
    $ ansible-playbook playbooks/insights.yaml -e owner=dev -e selector_database="ops_shd01_adb"
    PLAY [localhost] ************************************************************************************************

    ...

    PLAY RECAP ******************************************************************************************************
    localhost                  : ok=5    changed=1    unreachable=0    failed=0
    [gsoc@shd01-jmp01 platform-services]$
    ```

    Note: Key points to check for are

    ```text
    localhost                  : ok=5    changed=1    unreachable=0    failed=0
    ```

    If either of the above commands (environment dependant) return any errors in the body of the output, or the `PLAY RECAP` does not look like the above, then a failure or unanticipated event has occurred.  Check with the developer for potential corrective actions, or perform the steps listed in the [Back out and Fix on Fail Procedure](#Back-out-and-Fix-on-Fail-Procedure) section.

### Post Implementation Testing

If each of the following commands does not finish its output with "Success", then please check with the developer or proceed to the [Back out and Fix on Fail Procedure](#Back-out-and-Fix-on-Fail-Procedure) section.

#### Post Implementation Change Success Verification

Checks come in two categories

1. Review Azure portal details

    1. Connect to the Azure portal

    1. Select the correct subscription `Metron141` for __Development (dev)__ or `OpenMSS-Production` for __Production (ops)__

    1. Enter "mysql" in search box, and select "Azure Database of MySQL server" under the services section

    1. Ensure the MySQL Database "`dev-shd01-adb00`" or (`dev`) "`ops-shd01-adb00`" or (`ops`) or is present, and select instance.

    1. Verify desired Subscription, MySQL server name is showed in the "Azure Database for MySQL server" blade, and click "Delete"

    1. Select "Pricing tier" in the menu blade, details are as expected, "General Purpose", "2 vCores", and "60 GB" Storage.

    1. Click the "X" close button to return to the "Overview" blade

    1. Select "Alerts" in the menu blade, followed by clicking the "Managed alert rules" button

    1. Verify that 5 alert rules are displayed

    1. Click the "Manage action groups" button, and verify that there are 2 action names in `dev`, or a single action name in `ops`

1. Ensure connectivity

    The connectivity checks are done as part of the RT migration CIP, when connection to the new Managed MySQL Database is verified.

#### Post Implementation Product, Application, Infrastructure Verification

This sub-section is not applicable.

### Service Assurance Operations Post Verification

This sub-section is not directly applicable, CONSIDER ANY DETAILS THAT ARE PERTINENT

### Back out and Fix on Fail Procedure

1. Currently the process of backing out the changes are fully manual.

    __Development (dev)__

    1. Sign on to the Azure Portal

    1. Select the subscription `Metron141`

    1. Enter "mysql" in search box, and select "Azure Database of MySQL server" under the services section

    1. Select MySQL Database "`dev-shd01-adb00`" (if there are replicas select the highest numbered entry starting with "`dev-shd01-adb`")

    1. Verify desired Subscription, MySQL server name is showed in the "Azure Database for MySQL server" blade, and click "Delete"

    1. Repeat if any other replicas exist, and finish with the master "`dev-shd01-adb00`"

    1. Select the resource group associated with the MySQL server, "`dev_mysql03`"

    1. Select "Alerts" in the Resource Group menu bar

    1. Ensure Subscription and Resource group drop downs have the correct subscription and resource group

    1. Click the "Manage alert rules" button

    1. Select (check) all the rules (Active_Connections gt nnn, CPU_Usage ge 100, CPU_Usage gt 95, IO_Percentage ge 90, Storage gt 80)

    1. Click the "Delete" button

    1. Click the "Manage Action groups" button

    1. Click the Action name "`push_email01`"

    1. Click the "Delete" button on the "`push_email01`" blade.

    1. Click the Action name "`push_email02`"

    1. Click the "Delete" button on the "`push_email02`" blade.

    __Production (ops)__

    1. Sign on to the Azure Portal

    1. Select the subscription `OpenMSS-Production`

    1. Enter "mysql" in search box, and select "Azure Database of MySQL server" under the services section

    1. Select MySQL Database "`ops-shd01-adb00`" (if there are replicas select the highest numbered entry starting with "`ops-shd01-adb`")

    1. Verify desired Subscription, MySQL server name is showed in the "Azure Database for MySQL server" blade, and click "Delete"

    1. Repeat if any other replicas exist, and finish with the master "`ops-shd01-adb00`"

    1. Select the resource group associated with the MySQL server, "`ops_mysql01`"

    1. Select "Alerts" in the Resource Group menu bar

    1. Ensure Subscription and Resource group drop downs have the correct subscription and resource group

    1. Click the "Manage alert rules" button

    1. Select (check) all the rules (Active_Connections gt nnn, CPU_Usage ge 100, CPU_Usage gt 95, IO_Percentage ge 90, Storage gt 80)

    1. Click the "Delete" button

    1. Click the "Manage Action groups" button

    1. Click the Action name "`push_email01`"

    1. Click the "Delete" button on the "`push_email01`" blade.

### Post Implementation Monitoring

This sub-section is applicable, TO BE FILLED OUT

### Closure - Within 7 Days of Change Completion

This sub-section is not applicable, as the required actions are outside the scope of this document.
