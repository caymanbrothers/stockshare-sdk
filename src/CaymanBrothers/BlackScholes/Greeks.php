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

class Greeks extends BlackScholesFunctions
{   

    public function delta_call($q, $t, $d1)
    {

        $delta_call = exp(-$q*$t)*$this->N($d1);

        return $delta_call;

    }

    public function delta_put($q, $t, $d1)
    {

        $delta_put = exp(-$q*$t)*($this->N($d1)-1);

        return $delta_put;

    }

    public function gamma($q, $t, $S, $o, $d1) {
    
        $gamma = exp(-$q*$t)/($S*$o*sqrt($t)*1)/sqrt(2*pi())*exp(-pow($d1, 2)/2);
        
        return $gamma;
        
    }

    public function theta_call($S, $X, $t, $r, $o, $d1, $d2)
    {

        $theta_call = -(($S*(exp(-pow($d1, 2)/2))/sqrt(2*pi())*$o)/(2*sqrt($t)))-$r*$X*exp(-$r*$t)*$this->N($d2);

        return $theta_call;

    }

    public function theta_put($S, $X, $t, $r, $o, $d1, $d2)
    {

        $theta_put = -(($S*(exp(-pow($d1, 2)/2))/sqrt(2*pi())*$o)/(2*sqrt($t)))+$r*$X*exp(-$r*$t)*$this->N(-$d2);

        return $theta_put;

    }

    public function vega($S, $q, $t, $d1)
    {

        $vega = $S*exp(-$q*$t)*sqrt($t)*1/sqrt(2*pi())*exp(-pow($d1, 2)/2);
    
        return $vega;

    }

    public function rho_call($X, $t, $r, $d2)
    {

        $rho_call = $X*$t*exp(-$r*$t)*$this->N($d2);

        return $rho_call;

    }

    public function rho_put($X, $t, $r, $d2)
    {

        $rho_put = -$X*$t*exp(-$r*$t)*$this->N(-$d2);

        return $rho_put;
        
    }

}
?>
