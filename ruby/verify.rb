require 'jwt'
require 'openssl'
require_relative 'configurator'

input = ARGV.last
config = Configurator.create_default_configurations
claims = config['claims']
signature_headers = config['signature_headers']
public_key = config.public_key

begin
  JWT.decode(input, public_key, true, { 
    :algorithm => 'RS256',
    :iss => claims['iss'],
    :verify_iss => true,
    :aud => claims['aud'],
    :verify_aud => true,
    'sub' => claims['sub'], 
    :verify_sub => true,
    :verify_iat => true
  })
rescue => error
  print "fail: #{error.message}"
  exit(1)
end
print 'ok'
exit(0)
