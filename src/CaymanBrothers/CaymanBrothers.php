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

namespace CaymanBrothers;

use CaymanBrothers\BlackScholes\BlackScholes;

class CaymanBrothers
{
    public static function calculate(array $data = [])
    {   

        if (!$data["model"] || empty($data["model"])) {
            throw new \Exception("No valid calculation model was selected.", 1);
        }

        if ($data["model"] === "BlackScholes") {

            if (!$data['greeks'] || empty($data['greeks'])) {
                $data['greeks'] = false;
            }

            if (!$data['options']) {
                throw new \Exception("You've selected neither a call or a put option for your Black-Scholes calculation.", 2);
            }

            $BlackScholes = new BlackScholes($data['options'], $data['greeks'], $data['values']);

            return $BlackScholes->return();

        } else {

            throw new \Exception("The calculation model - " . $data['model'] . " - you've selected is either wrong or not specified.", 3);
            
        }
    }
}
