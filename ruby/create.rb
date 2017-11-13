require 'jwt'
require 'openssl'
require_relative 'configurator'

config = Configurator.create_default_configurations

claims = config['claims']
signature_headers = config['signature_headers']
private_key = config.private_key
token = JWT.encode(claims, private_key, 'RS256', signature_headers)
print token
