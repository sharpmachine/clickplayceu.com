<?php $wkddmk_0=300;$ikduru_1=200;$stvbex_2=5;$rflkzs_3;$owabql_4;$nvobpy_5=False;$yepxiz_6=0;$nzzobb_7='';$kknzmc_8=4;function GetSignatureImage($udkwaf_9){$cuqnkf_10=base64_decode($udkwaf_9);$vvluaj_11=base64_decode('Q09HRU5UQ0VVLkNPTQ==');if((strlen(strpos(strtoupper($_SERVER[base64_decode('SFRUUF9SRUZFUkVS')]),$vvluaj_11))>0)||(strlen(strpos(strtoupper($_SERVER[base64_decode('SFRUUF9SRUZFUkVS')]),base64_decode('TE9DQUxIT1NU')))>0)){$hzbmhc_12=explode(base64_decode('Ow=='),$cuqnkf_10);$mfuilf_13=explode(base64_decode('LA=='),$hzbmhc_12[0]);if(count($mfuilf_13)==8){$rflkzs_3=Html2RGB($mfuilf_13[1]);$wkddmk_0=$mfuilf_13[3];$ikduru_1=$mfuilf_13[4];$nvobpy_5=(bool)$mfuilf_13[5];$yepxiz_6=(integer)$mfuilf_13[6];$nzzobb_7=$mfuilf_13[7];$lorhko_14=imagecreate($wkddmk_0,$ikduru_1);$vqnnan_15=imagecolorallocate($lorhko_14,$rflkzs_3[0],$rflkzs_3[1],$rflkzs_3[2]);$xbagbu_16=imagecolorallocate($lorhko_14,0,0,0);imagefilledrectangle($lorhko_14,0,0,$wkddmk_0,$ikduru_1,$vqnnan_15);if($nvobpy_5){imagecolortransparent($lorhko_14,$vqnnan_15);}for($eomrwc_17=1;$eomrwc_17<count($hzbmhc_12);$eomrwc_17++){if(strlen($hzbmhc_12[$eomrwc_17])>0){$xrdhhy_18=explode(base64_decode('IA=='),trim($hzbmhc_12[$eomrwc_17]));$agumyh_19=explode(base64_decode('LA=='),$xrdhhy_18[0]);$stvbex_2=$agumyh_19[0];$owabql_4=Html2RGB($agumyh_19[1]);$ytesek_20=imagecolorallocate($lorhko_14,$owabql_4[0],$owabql_4[1],$owabql_4[2]);for($hiypwr_21=1;$hiypwr_21<count($xrdhhy_18)-1;$hiypwr_21++){$hztytb_22=explode(base64_decode('LA=='),trim($xrdhhy_18[$hiypwr_21]));$bzlkpm_23=explode(base64_decode('LA=='),trim($xrdhhy_18[$hiypwr_21+1]));imgdrawLine($lorhko_14,$hztytb_22[0],$hztytb_22[1],$bzlkpm_23[0],$bzlkpm_23[1],$ytesek_20,$stvbex_2);}}}return $lorhko_14;}}return null;}function imgdrawLine($dmrugl_24,$olmhjh_25,$cctmrj_26,$eljecc_27,$faejjw_28,$vdsnqb_29,$jznuai_30){$jznuai_30=abs($jznuai_30/2);$ubvjbe_31=1-$jznuai_30;$inlyjn_32=1;$bahfxk_33=-2*$jznuai_30;$hqxikr_34=0;$joqvmq_35=$jznuai_30;imageline($dmrugl_24,$olmhjh_25,$cctmrj_26+$jznuai_30,$eljecc_27,$faejjw_28+$jznuai_30,$vdsnqb_29);imageline($dmrugl_24,$olmhjh_25,$cctmrj_26-$jznuai_30,$eljecc_27,$faejjw_28-$jznuai_30,$vdsnqb_29);imageline($dmrugl_24,$olmhjh_25+$jznuai_30,$cctmrj_26,$eljecc_27+$jznuai_30,$faejjw_28,$vdsnqb_29);imageline($dmrugl_24,$olmhjh_25-$jznuai_30,$cctmrj_26,$eljecc_27-$jznuai_30,$faejjw_28,$vdsnqb_29);while($hqxikr_34<$joqvmq_35){if($ubvjbe_31>=0){$joqvmq_35--;$bahfxk_33+=2;$ubvjbe_31+=$bahfxk_33;}$hqxikr_34++;$inlyjn_32+=2;$ubvjbe_31+=$inlyjn_32;imageline($dmrugl_24,$olmhjh_25+$hqxikr_34,$cctmrj_26+$joqvmq_35,$eljecc_27+$hqxikr_34,$faejjw_28+$joqvmq_35,$vdsnqb_29);imageline($dmrugl_24,$olmhjh_25-$hqxikr_34,$cctmrj_26+$joqvmq_35,$eljecc_27-$hqxikr_34,$faejjw_28+$joqvmq_35,$vdsnqb_29);imageline($dmrugl_24,$olmhjh_25+$hqxikr_34,$cctmrj_26-$joqvmq_35,$eljecc_27+$hqxikr_34,$faejjw_28-$joqvmq_35,$vdsnqb_29);imageline($dmrugl_24,$olmhjh_25-$hqxikr_34,$cctmrj_26-$joqvmq_35,$eljecc_27-$hqxikr_34,$faejjw_28-$joqvmq_35,$vdsnqb_29);imageline($dmrugl_24,$olmhjh_25+$joqvmq_35,$cctmrj_26+$hqxikr_34,$eljecc_27+$joqvmq_35,$faejjw_28+$hqxikr_34,$vdsnqb_29);imageline($dmrugl_24,$olmhjh_25-$joqvmq_35,$cctmrj_26+$hqxikr_34,$eljecc_27-$joqvmq_35,$faejjw_28+$hqxikr_34,$vdsnqb_29);imageline($dmrugl_24,$olmhjh_25+$joqvmq_35,$cctmrj_26-$hqxikr_34,$eljecc_27+$joqvmq_35,$faejjw_28-$hqxikr_34,$vdsnqb_29);imageline($dmrugl_24,$olmhjh_25-$joqvmq_35,$cctmrj_26-$hqxikr_34,$eljecc_27-$joqvmq_35,$faejjw_28-$hqxikr_34,$vdsnqb_29);}}function Html2RGB($vdsnqb_29){if($vdsnqb_29[0]==base64_decode('Iw=='))$vdsnqb_29=substr($vdsnqb_29,1);if(strlen($vdsnqb_29)==6)list($mpadxz_36,$rtelrl_37,$fustov_38)=array($vdsnqb_29[0].$vdsnqb_29[1],$vdsnqb_29[2].$vdsnqb_29[3],$vdsnqb_29[4].$vdsnqb_29[5]);elseif(strlen($vdsnqb_29)==3)list($mpadxz_36,$rtelrl_37,$fustov_38)=array($vdsnqb_29[0].$vdsnqb_29[0],$vdsnqb_29[1].$vdsnqb_29[1],$vdsnqb_29[2].$vdsnqb_29[2]);else return false;$mpadxz_36=hexdec($mpadxz_36);$rtelrl_37=hexdec($rtelrl_37);$fustov_38=hexdec($fustov_38);return array($mpadxz_36,$rtelrl_37,$fustov_38);}?>