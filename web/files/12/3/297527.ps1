Function RandomPasswd(){

$kill_symbol= 8
#$passwd[array] =

[string]$passwd= ''



    for ($i = 0; $i -lt $kill_symbol-3; $i++)
    { 
        [int]$passwd_symb= Get-Random -Minimum 65 -Maximum 122
         
        if(($passwd_symb -gt 91) -and ($passwd_symb -lt 96))
        {
            [char]$passwd_symb_ch=$passwd_symb+5
        }
        else
        {
            [char]$passwd_symb_ch=$passwd_symb
        }

        $passwd+=$passwd_symb_ch.ToString()
 
    }
    [int]$passwd_symb_int= Get-Random -Minimum 100 -Maximum 9999
    $passwd+=$passwd_symb_int.ToString()



return $passwd
}

$curUser= $env:USERNAME

$user_adm= Get-ADUser $curUser

$ou= $user_adm.DistinguishedName

#$ou

$mas= $ou.Split(',')
#$mas.Length

$ou2= $mas[$mas.Length-3]+', '+$mas[$mas.Length-2]+', '+$mas[$mas.Length-1]

#$ou2.ToString()


$selUser= Get-ADUser -filter * -SearchBase $ou2 |select name, SamAccountName, DistinguishedName |Out-GridView -PassThru

Write-Host 'Selected User :'+$selUser
$userPasswd=RandomPasswd


if($selUser){
  #  $userPasswd='QwertyD5531'
    $selUser.DistinguishedName.ToString()

    $newPwd = ConvertTo-SecureString -AsPlainText $userPasswd -Force

      

   Set-ADAccountPassword -Identity $selUser.SamAccountName.ToString() -Reset  -NewPassword $newPwd

   Write-Host 'User Password: '$userPasswd
    }

Read-Host 'Preas any key'
