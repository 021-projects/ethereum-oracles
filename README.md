# Ethereum oracles library

A library of convenient interfaces for receiving statistics data from different ethereum oracles.

### Ethereum Mainnet oracles

**Offchain**

| Class                                      | Source                                                     | Features                    |
|--------------------------------------------|------------------------------------------------------------|-----------------------------|
| O21\EthereumOracles\OffChain\Blockscout    | https://blockscout.com/eth/mainnet/api/v1/gas-price-oracle | No                          |
| O21\EthereumOracles\OffChain\Etherchain    | https://etherchain.org/api/gasnow                          | Instant                     |
| O21\EthereumOracles\OffChain\EthGasStation | https://ethgasstation.info/json/ethgasAPI.json             | Instant, BlockNumber, Speed |
| O21\EthereumOracles\OffChain\MaticNetwork  | https://gasstation-mainnet.matic.network/                  | Instant, BlockNumber        |

### Usage

#### Get stats from Etherchain

```php
use O21\EthereumOracles\OffChain\Etherchain;
# ...

/** \O21\EthereumOracles\FeeStats\Stats $stats */
$stats = (new Etherchain)->getStats();
```


By default ``getStats()`` method fetching all provider supported features, but you can define only specific features like this
```php
use O21\EthereumOracles\OffChain\EthGasStation;
use O21\EthereumOracles\FeeStats\Feature;
# ...

(new EthGasStation)->getStats(Feature::Speed, Feature::BlockNumber);
```

##### Stats interface
| Property    | Description                                                | Required feature |
|-------------|------------------------------------------------------------|------------------|
| slow        | Fee for low priority (>= 30 minutes) transaction in Gwei   | No               |
| standard    | Fee for medium priority (< 5 minutes) transaction in Gwei  | No               |
| high        | Fee for high priority transaction (< 2 minutes) in Gwei    | No               |
| instant     | Fee for instant transaction (< 30 seconds) in Gwei         | Instant          |                                           |     |
| speed       | Smallest value of (gasUsed / gaslimit) from last 10 blocks | Speed            |
| blockNumber | Latest block number                                        | BlockNumber      |