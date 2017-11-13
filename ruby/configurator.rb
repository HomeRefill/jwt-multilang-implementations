class Configurator
  def self.create_default_configurations
    now = Time.now.to_i
    options = {
      'keys_path' => __dir__ + '/../keys',
      'supported_signatures_algorithms' => ['RS256'],
      'signature_headers' => {
        'alg' => 'RS256',
        'crit' => ['exp', 'aud']
      },

      'private_key' => "signature.key",
      'public_key'  => "signature.key.pub",
      'passphrase'  => '123456',

      'claims' => {
        'nbf' => now,
        'iat' => now,
        'exp' => now + 3600,
        'iss' => 'HomerefillIssuer',
        'aud' => 'HomerefillAudience',
        'sub' => 'HomerefillSubject',
        'is_root' => true
      },

      'signature_key_headers' => {
        'kid' => 'HomerefillBackofficeAccessSignatureKey',
        'alg' => 'RS256',
        'use' => 'sig'
      }
    };
    new(options)
  end

  def initialize(options)
    @options = options
  end

  def private_key
    path = [@options['keys_path'], @options['private_key']].join('/')
    file = File.read(path)
    OpenSSL::PKey::RSA.new(file, @options['passphrase'])
  end

  def public_key
    path = [@options['keys_path'], @options['public_key']].join('/')
    file = File.read(path)
    OpenSSL::PKey::RSA.new(file)
  end

  def [](key)
    @options[key]
  end
end
