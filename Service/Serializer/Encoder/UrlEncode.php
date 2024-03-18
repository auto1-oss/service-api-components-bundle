<?php

namespace Auto1\ServiceAPIComponentsBundle\Service\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\EncoderInterface;

class UrlEncode implements EncoderInterface
{
    /**
     * Encodes PHP data to a JSON string.
     *
     * {@inheritdoc}
     */
    public function encode($data, $format, array $context = []): string
    {
        $data = $this->convertCamelCaseToSnakeCase($data);
        $encoded = http_build_query($data);

        return $encoded;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEncoding($format): bool
    {
        return UrlEncoder::FORMAT === $format;
    }

    /**
     * Convert camelCase type array's keys to under_score+lowercase type array's keys.
     *
     * @param array $array array to convert
     *
     * @return array under_score array
     */
    private function convertCamelCaseToSnakeCase($array)
    {
        $underscoreArray = [];

        foreach ($array as $key => $val) {
            $newKey = is_numeric($key) ? $key : ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $key)), '_');

            if (!is_array($val)) {
                $underscoreArray[$newKey] = $val;
            } else {
                $underscoreArray[$newKey] = $this->convertCamelCaseToSnakeCase($val);
            }
        }

        return $underscoreArray;
    }
}
