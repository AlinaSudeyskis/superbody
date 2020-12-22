<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Welcome class
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Welcome_model extends CI_Model
{
    /**
     * Сохранение E-mail в БД для подписки
     *
     * @param $email
     * @param $name
     * @param $date
     * @return bool
     */
    public function setNewSubscriber($email, $name, $date)
    {
        $sel_email = $this->db->query('SELECT `s_id` FROM `subscription` WHERE `s_email`=? LIMIT 1', $email);
        
        if ($sel_email !== false and 0 == $sel_email->num_rows())
        {
            $ins_email = $this->db->query('
                INSERT INTO `subscription` (`s_email`, `s_name`, `s_date`)
                VALUES (?, ?, ?)', array($email, $name, $date));

            if ($ins_email !== false and 1 == $this->db->affected_rows())
            {
                return true;
            }
            elseif ($ins_email === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
                return false;
            }
            else
            {
                return 2;
            }
        }
        elseif ($sel_email === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else {
            return 3;
        }
    }

    /**
     * Удаление email из подписчиков
     *
     * @param $email
     * @return bool
     */
    public function unsubscribeEmail($email)
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `s_unsubscribe` FROM `subscription` WHERE `s_email`=? LIMIT 1', $email);
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            if($row->s_unsubscribe == 0)
            {
                $up_data = $this->db->query('UPDATE `subscription` SET `s_unsubscribe`=1 WHERE `s_email`=? LIMIT 1', $email);
                if($up_data !== false and 1 == $this->db->affected_rows())
                {
                    $result = true;
                }
                elseif($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            else
            {
                $result = 227;
            }
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        else
        {
            $result = 228;
        }


        return $result;
    }

    /**
     * Выборка данных сайта
     *
     * @return bool
     */
    public function getSiteInfo()
    {
        $result = false;

        $sel_info = $this->db->query('
            SELECT `si_id`, `si_logo`, `si_index_title`, `si_index_text`, `si_soc_facebook`, `si_soc_twitter`, `si_soc_pinterest`, 
              `si_soc_google_plus`, `si_soc_tumblr`, `si_soc_instagram`, `si_soc_ok`, `si_soc_vk`, `si_soc_youtube`, 
              `si_phone`, `si_mes_telegram`, `si_mes_whatsapp`, `si_mes_viber`, `si_email`, `si_rights`, `si_agreement`, 
              `si_policy`, `si_personal_data`, `si_personal_data_text`, `si_offer_data`, `si_footer`, `si_about`, `si_contacts_text1`, 
              `si_contacts_text2`, `si_contacts_bg`, `si_auth_display`, `si_auth_title1`, `si_auth_title2`, `si_auth_subtitle1`, `si_auth_subtitle2`, 
              `si_auth_text1`, `si_auth_text2`, `si_auth_url1`, `si_auth_url2`, `si_auth_url_name1`, `si_auth_url_name2`, 
              `si_spec_display`, `si_spec_name`, `si_spec_title`, `si_spec_text`, `si_spec_url`, `si_spec_url_text`, `si_cookies_title`, `si_cookies_text`,
              `si_premium_display`, `si_advertising_display`, `si_advertising_mobile`, `si_advertising_mobile_hide`, `si_advertising_vertical`, `si_advertising_vertical_hide`, 
              `si_advertising_vertical_mobile`, `si_advertising_vertical_mobile_hide`, `si_advertising_horizontal`, `si_advertising_horizontal_hide`, 
              `si_advertising_horizontal_mobile`, `si_advertising_horizontal_mobile_hide`, `si_advertising_before_workout`, `si_advertising_before_workout_hide`, 
              `si_advertising_popup`, `si_advertising_month_price`, `si_blog_share_top`, `si_blog_share_bottom`
            FROM `site_info` LIMIT 1');

        if ($sel_info !== false and 1 == $sel_info->num_rows())
        {
            $row = $sel_info->row();

            $result['si_id']                  = $row->si_id;
            $result['logotype']               = is_file($row->si_logo) ? mb_substr($row->si_logo, 1) : null;
            $result['index_title']            = $row->si_index_title;
            $result['index_text']             = $row->si_index_text;
            $result['soc_facebook']           = $row->si_soc_facebook;
            $result['soc_twitter']            = $row->si_soc_twitter;
            $result['soc_pinterest']          = $row->si_soc_pinterest;
            $result['soc_google_p']           = $row->si_soc_google_plus;
            $result['soc_tumblr']             = $row->si_soc_tumblr;
            $result['soc_instagram']          = $row->si_soc_instagram;
            $result['soc_ok']                 = $row->si_soc_ok;
            $result['soc_vk']                 = $row->si_soc_vk;
            $result['soc_youtube']            = $row->si_soc_youtube;
            $result['phone']                  = $row->si_phone;
            $result['mes_telegram']           = $row->si_mes_telegram;
            $result['mes_whatsapp']           = $row->si_mes_whatsapp;
            $result['mes_viber']              = $row->si_mes_viber;
            $result['email']                  = $row->si_email;
            $result['rights']                 = $row->si_rights;
            $result['agreement']              = $row->si_agreement;
            $result['private_policy']         = $row->si_policy;
            $result['personal_data']          = $row->si_personal_data;
            $result['personal_data_text']     = $row->si_personal_data_text;
            $result['offer_data']             = $row->si_offer_data;
            $result['footer']                 = $row->si_footer;
            $result['about']                  = nl2br(parent::showBBcodes($row->si_about));
            $result['contacts_text1']         = $row->si_contacts_text1;
            $result['contacts_text2']         = $row->si_contacts_text2;
            $result['contacts_bg']            = (is_file($row->si_contacts_bg)) ? mb_substr($row->si_contacts_bg, 1) : null;
            $result['banners']                = array();
            $result['auth_display']           = $row->si_auth_display;
            $result['auth_title1']            = $row->si_auth_title1;
            $result['auth_title2']            = $row->si_auth_title2;
            $result['auth_subtitle1']         = $row->si_auth_subtitle1;
            $result['auth_subtitle2']         = $row->si_auth_subtitle2;
            $result['auth_text1']             = $row->si_auth_text1;
            $result['auth_text2']             = $row->si_auth_text2;
            $result['auth_url1']              = $row->si_auth_url1;
            $result['auth_url2']              = $row->si_auth_url2;
            $result['auth_url_name1']         = $row->si_auth_url_name1;
            $result['auth_url_name2']         = $row->si_auth_url_name2;
            $result['spec_display']           = $row->si_spec_display;
            $result['spec_name']              = $row->si_spec_name;
            $result['spec_title']             = $row->si_spec_title;
            $result['spec_text']              = $row->si_spec_text;
            $result['spec_url']               = $row->si_spec_url;
            $result['spec_url_text']          = $row->si_spec_url_text;
            $result['cookies_title']          = $row->si_cookies_title;
            $result['cookies_text']           = $row->si_cookies_text;
            $result['advertising_premium_display'] = $row->si_premium_display;
            $result['advertising_display']         = explode(";", $row->si_advertising_display);
            $result['advertising_mobile']          = $row->si_advertising_mobile;
            $result['advertising_mobile_hide']     = $row->si_advertising_mobile_hide;
            $result['advertising_vertical']        = $row->si_advertising_vertical;
            $result['advertising_vertical_hide']   = $row->si_advertising_vertical_hide;
            $result['advertising_horizontal']      = $row->si_advertising_horizontal;
            $result['advertising_horizontal_hide'] = $row->si_advertising_horizontal_hide;
            $result['advertising_vertical_mobile']        = $row->si_advertising_vertical_mobile;
            $result['advertising_vertical_mobile_hide']   = $row->si_advertising_vertical_mobile_hide;
            $result['advertising_horizontal_mobile']      = $row->si_advertising_horizontal_mobile;
            $result['advertising_horizontal_mobile_hide'] = $row->si_advertising_horizontal_mobile_hide;
            $result['advertising_before_workout']         = $row->si_advertising_before_workout;
            $result['advertising_before_workout_hide']    = $row->si_advertising_before_workout_hide;
            $result['advertising_popup']           = $row->si_advertising_popup;
            $result['advertising_month_price']     = $row->si_advertising_month_price;
            $result['blog_share_top']    = $row->si_blog_share_top;
            $result['blog_share_bottom'] = $row->si_blog_share_bottom;

            $sel_banners = $this->db->query('
                SELECT `sb_id`, `sb_image`, `sb_video_url`, `sb_url`, `sb_advertising` FROM `site_banners` WHERE `sb_blocked`=0 ORDER BY `sb_id`');
            if ($sel_banners !== false and 0 < $sel_banners->num_rows())
            {
                $i = 0;
                foreach ($sel_banners->result() as $row)
                {
                    if (is_file($row->sb_image) or !empty($row->sb_video_url) or !empty($row->sb_advertising))
                    {
                        $result['banners'][$i]['id']          = $row->sb_id;
                        $result['banners'][$i]['image']       = (!empty($row->sb_image)) ? mb_substr($row->sb_image, 1) : '';
                        $result['banners'][$i]['video_url']   = $row->sb_video_url;
                        $result['banners'][$i]['url']         = $row->sb_url;
                        $result['banners'][$i]['advertising'] = $row->sb_advertising;

                        $i++;
                    }
                }
                unset($row);
            }
            elseif ($sel_banners === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif ($sel_info === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function getSiteMetaData()
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `smt_id`, `smt_title`, `smt_keywords`, `smt_description` 
            FROM `site_meta_tags`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            foreach ($sel_data->result() as $row)
            {
                $result[$row->smt_id]['title']       = $row->smt_title;
                $result[$row->smt_id]['keywords']    = $row->smt_keywords;
                $result[$row->smt_id]['description'] = $row->smt_description;
            }
            unset($row);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }
}