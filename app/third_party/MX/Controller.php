<?php 
goto bdjlcWEARQ; 
h_yIqBxQGQ: require dirname(__FILE__) . "/Base.php"; 
goto uYDK6bcOfX; 
bdjlcWEARQ: defined("BASEPATH") or exit("No direct script access allowed"); 
goto h_yIqBxQGQ; 
uYDK6bcOfX: class MX_Controller { 
    public $autoload = array(); 
    public function __construct() { 
        goto V_BCDaQyvc; 
        WNR6xKYrGw: 
        switch ($SAdgyzA3bu->status) { 
        case "error": 
            // goto YL7d69fhID; 
            // nzC4ZC3Br9: goto IUXZUonyWn; 
            // goto hHEZYQXx3H; 
            // YL7d69fhID: $hLusZRp20Y = base64_encode($SAdgyzA3bu->message); 
            // goto DRln0VmEdR; 
            // BUTvKy_iby: exit(0); 
            // goto nzC4ZC3Br9; 
            // DRln0VmEdR: redirect(PATH . "module?error=" . $hLusZRp20Y); 
            // goto BUTvKy_iby; 
            set_cookie("lc_verified", base64_encode("verified"), 1209600); 
            goto IUXZUonyWn; 
        hHEZYQXx3H: case "success": 
            set_cookie("lc_verified", base64_encode("verified"), 1209600); 
            goto IUXZUonyWn; 
        } 
        goto HRXuEyFqC2; 
        fGMW7pUjcu: rhws6AKpgm: goto Gf1jMiuGPp; 
        H9HcWKUce4: goto El21OIHcKe; 
        goto fbuO_S9f_U; 
        SukT3F2Rnq: if (!(isset($_COOKIE["lc_verified"]) && $_COOKIE["lc_verified"] != '')) { 
            goto rhws6AKpgm; 
        } 
        goto Osr4r4_q3K; 
        m0UCNNIRaN: redirect(PATH . "module?error=" . $hLusZRp20Y); 
        goto ZbVaL4qjUB; 
        fIc_cuXbi7: redirect(PATH . "module?error=" . $hLusZRp20Y); 
        goto dFvybAlySI; 
        ZbVaL4qjUB: exit(0); 
        goto H9HcWKUce4; 
        qxDOJhymVb: kCU6IvyonY: goto LfjNoRJEhv; 
        vxZv03PjlH: $uGFnPgIt88 = "non-verified"; 
        goto BXVS3co7Qx; 
        cgcb5MliVE: goto t1ENjQCMF5; 
        goto a0tVbj9_LV; 
        DS_gin9OIL: $hLusZRp20Y = $OFeVAhezzz; 
        goto m0UCNNIRaN; 
        gNg5agpfFT: $o0lL2glf0r->db->query("DELETE FROM general_sessions WHERE timestamp < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY))"); 
        goto P3uRVDcG9v; 
        A0xdz2Rl7W: $this->load->initialize($this); 
        goto s0zTuqMaac; 
        OIzROo19YN: $J7vcf5SQKq = base_url(); 
        goto nuMSVRJnIt; 
        aUs8v8tROv: $hLusZRp20Y = $OFeVAhezzz; 
        goto BSoRhfBdz3; 
        zCEfSB08Za: $PN8eHvclmS = []; 
        goto ZxMyaLzZTg; 
        PWfDjDNfaq: $OFeVAhezzz = base64_encode($OFeVAhezzz); 
        goto VghhXhYbHT; 
        rEsjcwUvl8: Modules::$registry[strtolower($ykoko4xeks)] = $this; 
        goto aZco4Qvxz3; 
        ZxMyaLzZTg: $jZNr0tOQH2 = session("user_current_info"); 
        goto DHFRm43z6d; 
        q_absEqz_Z: $pIVDtP9Qqx = ["logout"]; 
        goto HPENBYKJ31; 
        Osr4r4_q3K: $oT7wqqU7u1 = base64_decode($_COOKIE["lc_verified"]); 
        goto fGMW7pUjcu; 
        DHFRm43z6d: switch ($jZNr0tOQH2["role"]) { 
            case "supporter": 
                $PN8eHvclmS = array("setting", "module", "provider"); 
                goto hV0QT4igco; 
            case "user": $PN8eHvclmS = array("users", "setting", "module", "provider", "category"); 
            goto hV0QT4igco; 
        } 
        goto GWXTym1uaa; 
        BSoRhfBdz3: redirect(PATH . "module?error=" . $hLusZRp20Y); 
        goto HYltXYK4LD; 
        BXVS3co7Qx: if (!(isset($_COOKIE["verify_maintenance_mode"]) && $_COOKIE["verify_maintenance_mode"] != '')) { 
            goto t4QeTxJdvB; 
        } 
        goto TTRaPk2iC9; 
        N611sSbxsA: if (!($uGFnPgIt88 != "verified" && $iARtCgpC8Z && segment(1) != "maintenance")) { 
            goto jwaJTD84jk; 
        } 
        goto i0RfO76NMl; 
        yzmCaetKfb: redirect(PATH); 
        goto dcuBOz0RK0; 
        Z5HsTp7PLR: log_message("debug", $ykoko4xeks . " MX_Controller Initialized"); 
        goto rEsjcwUvl8; 
        eGakiX1mJA: mAI3fuLKDY: 
        goto ODzIJmiS5A; 
        hz5lnsjVJa: $dbJ9AkGcns = $this->__curl($Pc0Fe5kg8D); 
        goto Lac4Wn3TOn; 
        XnSKXPUHZd: El21OIHcKe: goto LdcHXJAdQj; 
        U0CkwEghTE: $iARtCgpC8Z = $this->__check_maintenance_mode(); 
        goto N611sSbxsA; 
        sn9yg461mk: if (!session("uid")) { 
            goto p8q4UWVClY; 
        } 
        goto zCEfSB08Za; 
        vzXWz5EqiA: if (!(segment(1) != '' && segment(1) != "cron" && segment(1) != "checkout" && !in_array(segment(2), ["set_language"]))) { 
            goto SUaMiYmkx8; 
        } 
        goto MM7hjw83Vs; 
        i0RfO76NMl: redirect(cn("maintenance")); 
        goto n080qKlCTs; 
        dDJ02ZApxW: if (!(segment(1) != "module" && $jZNr0tOQH2["role"] == "admin")) { 
            goto kCU6IvyonY; 
        } 
        goto MGDsnn0lxg; 
        r5S8eGSfKL: SUaMiYmkx8: goto eGakiX1mJA; 
        HYltXYK4LD: exit(0); 
        goto cgcb5MliVE; 
        Lac4Wn3TOn: $OFeVAhezzz = 
        "There is some issue with your purchase code, please contact with me via email tuyennguyen2906@gmail.com"; 
        goto PWfDjDNfaq; 
        dFvybAlySI: exit(0); 
        goto prZ7QrksUj; 
        i7IyUppbVw: mEdWU7S4RD: goto sn9yg461mk; 
        prZ7QrksUj: goto VGc1zPa1Nx; 
        goto VwH04OErov; 
        WSn8H9hR5c: VGc1zPa1Nx: goto qxDOJhymVb; 
        MM7hjw83Vs: redirect(PATH); 
        goto r5S8eGSfKL; GWXTym1uaa: xHZWrv1_Nw: goto J_wfcu_IPY; 
        CXjTJ7rDOZ: if (!($jZNr0tOQH2["role"] != "admin" && in_array($this->router->fetch_class(), $PN8eHvclmS))) { 
            goto J4emyQlqrq; 
        } 
        goto iKIDFeUGMJ; 
        P3uRVDcG9v: p8q4UWVClY: goto v2Kcdbpg9y; 
        LfjNoRJEhv: Iu4REYb33c: goto gNg5agpfFT; 
        pRP3LU9IUV: $this->load = clone load_class("Loader"); 
        goto A0xdz2Rl7W; 
        iKIDFeUGMJ: redirect(PATH . "statistics"); 
        goto Knfu0eqTqi; 
        Kr7pbapCrj: $oT7wqqU7u1 = ''; 
        goto SukT3F2Rnq; 
        TTRaPk2iC9: $uGFnPgIt88 = encrypt_decode($_COOKIE["verify_maintenance_mode"]); 
        goto cHzfO0VgBY; 
        aZco4Qvxz3: date_default_timezone_set(TIMEZONE); 
        goto pRP3LU9IUV; 
        wZqsW7Qmpm: if (!(!session("uid") && !$iARtCgpC8Z)) { 
            goto mEdWU7S4RD; 
        } 
        goto J1F6418vmw; 
        HRXuEyFqC2: KlmD1fZvua: goto glR7b2OYE6; 
        rcuO55pGql: $TD0kf21gZg = ["auth", "client", "blog", "contact", "checkout", "paypal", "package", "custom_page"]; 
        goto q_absEqz_Z; 
        Knfu0eqTqi: J4emyQlqrq: goto Kr7pbapCrj; 
        J1F6418vmw: if (!(!in_array($this->router->fetch_class(), $TD0kf21gZg) && !in_array($this->router->fetch_method(), $pIVDtP9Qqx))) { 
            goto mAI3fuLKDY; 
        } 
        goto vzXWz5EqiA; 
        LdcHXJAdQj: t1ENjQCMF5: goto WSn8H9hR5c; 
        dcuBOz0RK0: IIOIXCoBBB: goto i7IyUppbVw; 
        HvFaYSpmlC: $SAdgyzA3bu = json_decode($dbJ9AkGcns); 
        goto S8lOEV7riB; 
        rlhD06Ajc7: if (!empty($HJw3QpTFsS)) { 
            goto GD_UP6mTNi; 
        } 
        goto L7X1O9hbJs; 
        a0tVbj9_LV: c6iZj245im: goto HvFaYSpmlC; 
        HPENBYKJ31: $mGh8_txw9t = ["update"]; 
        goto wZqsW7Qmpm; 
        fbuO_S9f_U: bm5Xes69wn: goto WNR6xKYrGw; 
        L7X1O9hbJs: $hLusZRp20Y = $OFeVAhezzz; 
        goto fIc_cuXbi7; 
        MGDsnn0lxg: $HJw3QpTFsS = $o0lL2glf0r->db->select("purchase_code")->where("pid", 24815787)->get("general_purchase")->row()->purchase_code; 
        goto rlhD06Ajc7; 
        J_wfcu_IPY: hV0QT4igco: goto CXjTJ7rDOZ; 
        V_BCDaQyvc: $ykoko4xeks = str_replace(CI::$APP->config->item("controller_suffix"), '', get_class($this)); 
        goto Z5HsTp7PLR; 
        s0zTuqMaac: $o0lL2glf0r =& get_instance(); 
        goto vxZv03PjlH; 
        VghhXhYbHT: if ($dbJ9AkGcns != '') { 
            goto c6iZj245im; 
        } 
        goto aUs8v8tROv; 
        n080qKlCTs: jwaJTD84jk: goto rcuO55pGql; 
        cHzfO0VgBY: t4QeTxJdvB: goto U0CkwEghTE; 
        Gf1jMiuGPp: if (!($oT7wqqU7u1 != "verified" && segment(2) != "logout")) { 
            goto Iu4REYb33c; 
        } 
        goto dDJ02ZApxW; 
        v2Kcdbpg9y: $this->load->_autoloader($this->autoload); 
        goto OYntAVrStH; 
        VwH04OErov: GD_UP6mTNi: goto OIzROo19YN; 
        nuMSVRJnIt: $Pc0Fe5kg8D = "https://smartpanelsmm.com/pc_verify/install?type=upgrade&purchase_code=" . urlencode($HJw3QpTFsS) . "&domain=" . urlencode($J7vcf5SQKq); 
        goto hz5lnsjVJa; 
        S8lOEV7riB: if (is_object($SAdgyzA3bu)) { 
            goto bm5Xes69wn; 
        } 
        goto DS_gin9OIL; 
        ODzIJmiS5A: if (!in_array($this->router->fetch_method(), $mGh8_txw9t)) { 
            goto IIOIXCoBBB; 
        } 
        goto yzmCaetKfb; 
        glR7b2OYE6: IUXZUonyWn: goto XnSKXPUHZd; 
        OYntAVrStH: 
    } 
    public function __get($ykoko4xeks) { 
        return CI::$APP->{$ykoko4xeks}; 
    } 
    private function __check_maintenance_mode() { 
        goto zitIKoYcJc; 
        BdqxVEOwML: return false; 
        goto Ppi6T3EEmf; 
        HmbSRkXF3T: $o0lL2glf0r->db->from(OPTIONS); 
        goto sIDNoGbtG5; 
        CrdLYa6kZO: if ($dbJ9AkGcns->value) { 
            goto GSKe01XrtM; 
        } 
        goto BdqxVEOwML; 
        u5qOtaFB0K: $LixyqhFHMd = $this->db->get(); 
        goto PZCv1rFHqS; 
        qUpd1qojId: K9xhz1Aj88: goto NDCTvrFm47; 
        XtgvQ21cM8: $jZNr0tOQH2 = $o0lL2glf0r->db->select("value"); 
        goto HmbSRkXF3T; 
        fKoW7tn75l: raq_a_VOJ3: goto qUpd1qojId; 
        d55sV7a01J: n3r0WZodfz: goto CrdLYa6kZO; 
        RD63HF0Sjn: return false; 
        goto cHnBQv21xi; 
        XACbqj9BC_: GSKe01XrtM: goto H3erLWqpLr; 
        WNu7UW3cVE: if (!empty($dbJ9AkGcns)) { 
            goto n3r0WZodfz; 
        } 
        goto RD63HF0Sjn; 
        H3erLWqpLr: return true; 
        goto fKoW7tn75l; 
        zitIKoYcJc: $o0lL2glf0r =& get_instance(); 
        goto XtgvQ21cM8; 
        cHnBQv21xi: goto K9xhz1Aj88; 
        goto d55sV7a01J; 
        sIDNoGbtG5: $o0lL2glf0r->db->where("name", "is_maintenance_mode"); 
        goto u5qOtaFB0K; 
        Ppi6T3EEmf: goto raq_a_VOJ3; 
        goto XACbqj9BC_; 
        PZCv1rFHqS: $dbJ9AkGcns = $LixyqhFHMd->row(); 
        goto WNu7UW3cVE; 
        NDCTvrFm47: 
    } 
    private function __curl($Pc0Fe5kg8D) { 
        goto JnCnATQKcj; 
        Hi8bzjLoEf: curl_setopt($ZYLToMg12S, CURLOPT_TIMEOUT, 60); 
        goto oGB18p_9t9; 
        Pnu3rRv7wq: curl_setopt($ZYLToMg12S, CURLOPT_VERBOSE, 1); 
        goto jIhU4Astl8; 
        STgi4g1Z9Z: $dbJ9AkGcns = curl_exec($ZYLToMg12S); 
        goto JdavJD0TV6; 
        M5bonfhrgn: curl_setopt($ZYLToMg12S, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); 
        goto PNVKjl4LCW; 
        i0v60rUZqH: curl_setopt($ZYLToMg12S, CURLOPT_URL, $Pc0Fe5kg8D); 
        goto Pnu3rRv7wq; 
        JdavJD0TV6: curl_close($ZYLToMg12S); 
        goto TX8vMIgM_f; 
        KOQSPx00qe: curl_setopt($ZYLToMg12S, CURLOPT_CONNECTTIMEOUT, 0); 
        goto Hi8bzjLoEf; 
        jIhU4Astl8: curl_setopt($ZYLToMg12S, CURLOPT_RETURNTRANSFER, 1); 
        goto MYS3twaFXO; 
        oGB18p_9t9: curl_setopt($ZYLToMg12S, CURLOPT_SSL_VERIFYPEER, false); 
        goto STgi4g1Z9Z; 
        JnCnATQKcj: $ZYLToMg12S = curl_init(); 
        goto i0v60rUZqH; 
        PNVKjl4LCW: curl_setopt($ZYLToMg12S, CURLOPT_HEADER, 0); 
        goto KOQSPx00qe; 
        MYS3twaFXO: curl_setopt($ZYLToMg12S, CURLOPT_AUTOREFERER, false); 
        goto M5bonfhrgn; 
        TX8vMIgM_f: return $dbJ9AkGcns; 
        goto tzRImkQWKD; 
        tzRImkQWKD: 
    } 
}