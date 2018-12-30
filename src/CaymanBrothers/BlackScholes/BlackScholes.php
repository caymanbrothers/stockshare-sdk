<?

/**
 * Copyright 2018 Cayman Brothers Corporation
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Cayman Brothers.
 *
 * As with any software that integrates with our platform, your use
 * of this software is subject to Alidrin.com's Developer Principles and
 * Policies [https://9bn.de/api/tos?lang=de]. This copyright notice
 * shall be included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */

namespace CaymanBrothers\BlackScholes;

use \CaymanBrothers\BlackScholes\BlackScholesFunctions;
use \CaymanBrothers\BlackScholes\Greeks;

class BlackScholes
{
    public function __construct(array $options = [], bool $greeks, array $values) {

        if (in_array("Call", $options) || in_array("call", $options)) {
            $this->call = true;
        }

        if (in_array("Put", $options) || in_array("put", $options)) {
            $this->put = true;
        }

        if (!isset($values['underlying_price'])) {
            throw new \Exception("The provided underlying_price is either not defined or has a false type.", 4);   
        }

        if (!isset($values['strike'])) {
            throw new \Exception("The provided strike is either not defined or has a false type.", 5);   
        }

        if (!isset($values['expiration'])) {
            throw new \Exception("The provided expiration time is either not defined or has a false type.", 6);   
        }

        if (!isset($values['interest_rate'])) {
            throw new \Exception("The provided interest_rate is either not defined or has a false type.", 7);   
        }

        if (!isset($values['volatility'])) {
            throw new \Exception("The provided volatility is either not defined or has a false type.", 8);   
        }

        if (!isset($values['dividend_yield'])) {
            throw new \Exception("The provided dividend_yield is either not defined or has a false type.", 9);   
        }

        $this->greeks = $greeks;

        $this->functions = new BlackScholesFunctions();
        $this->option_greeks = new Greeks();

        $this->S = $values['underlying_price'];
        $this->X = $values['strike'];
        $this->t = $values['expiration']/365;
        $this->r = $values['interest_rate'];
        $this->o = $values['volatility'];
        $this->q = $values['dividend_yield'];

    }

    public function d1()
    {
        return $this->functions->d1($this->S, $this->X, $this->t, $this->r, $this->q, $this->o);
    }

    public function d2()
    {
        return $this->functions->d2($this->d1(), $this->o, $this->t);
    }

    public function call()
    {
        return $this->functions->call($this->S, $this->q, $this->t, $this->d1(), $this->X, $this->r, $this->d2());
    }

    public function put()
    {
        return $this->functions->put($this->S, $this->q, $this->t, $this->d1(), $this->X, $this->r, $this->d2());
    }

    /**
     * Greeks
     */

    public function delta_call()
    {
        return $this->option_greeks->delta_call($this->q, $this->t, $this->d1());
    }

    public function delta_put()
    {
        return $this->option_greeks->delta_put($this->q, $this->t, $this->d1());
    }

    public function gamma()
    {
        return $this->option_greeks->gamma($this->q, $this->t, $this->S, $this->o, $this->d1());
    }

    public function theta_call()
    {
        return $this->option_greeks->theta_call($this->S, $this->X, $this->t, $this->r, $this->o, $this->d1(), $this->d2());
    }

    public function theta_put()
    {
        return $this->option_greeks->theta_put($this->S, $this->X, $this->t, $this->r, $this->o, $this->d1(), $this->d2());
    }

    public function vega()
    {
        return $this->option_greeks->vega($this->S, $this->q, $this->t, $this->d1());
    }

    public function rho_call()
    {
        return $this->option_greeks->rho_call($this->X, $this->t, $this->r, $this->d2());
    }

    public function rho_put()
    {
        return $this->option_greeks->rho_put($this->X, $this->t, $this->r, $this->d2());
    }

    public function return()
    {

        if (isset($this->call)) {
            $return['BlackScholes']['Options']['Call']['Price'] = $this->call();
        }

       if (isset($this->put)) {
            $return['BlackScholes']['Options']['Put']['Price'] = $this->put();
       }

       if (isset($this->call) && $this->greeks) {
            $return['BlackScholes']['Options']['Call']['Greeks'] = array('delta' => $this->delta_call(), 'gamma' => $this->gamma(), 'theta' => $this->theta_call(), 'vega' => $this->vega(), 'rho' => $this->rho_call());
       }

       if (isset($this->put) && $this->greeks) {
            $return['BlackScholes']['Options']['Put']['Greeks'] = array('delta' => $this->delta_put(), 'gamma' => $this->gamma(), 'theta' => $this->theta_put(), 'vega' => $this->vega(), 'rho' => $this->rho_put());
        }

        return $return;
    }

}

?>